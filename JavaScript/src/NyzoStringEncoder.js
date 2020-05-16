// ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringEncoder.java
// We tried to sick close to he java impl, but circular references and differences in the languages lead to some differences.

const createHash = require('create-hash')
const { NyzoStringPublicIdentifier } = require('./NyzoStringPublicIdentifier')
const { NyzoStringPrivateSeed } = require('./NyzoStringPrivateSeed')
const { NyzoStringPrefilledData } = require('./NyzoStringPrefilledData')
const { NyzoStringMicropay } = require('./NyzoStringMicropay')
const { NyzoStringTransaction } = require('./NyzoStringTransaction')
const { NyzoStringSignature } = require('./NyzoStringSignature')


const CHARACTER_LOOKUP = "0123456789" +
            "abcdefghijkmnopqrstuvwxyz" +  // all except lowercase "L"
            "ABCDEFGHIJKLMNPQRSTUVWXYZ" +  // all except uppercase "o"
            //"*+=_").toCharArray();       // old encoding, less URL-friendly
            "-.~_"                         // see https://tools.ietf.org/html/rfc3986#section-2.3

// These were computed once by the test suite, then hardcoded here so NyzoStringType is not needed in real code.
const NYZO_PREFIXES_BYTES = {
    'pre_': new Uint8Array([97, 163, 191]),
    'key_': new Uint8Array([80, 232, 127]),
    'id__': new Uint8Array([72, 223, 255]),
    'pay_': new Uint8Array([96, 168, 127]),
    'tx__': new Uint8Array([114, 15, 255]),
    'sig_': new Uint8Array([0x6d,0x24,0x3f])
}

// Get a list of valid prefixes for future use.
const NYZO_PREFIXES = Array.from(Object.keys(NYZO_PREFIXES_BYTES))

const HEADER_LENGTH = 4

class NyzoStringEncoder {

  constructor() {
        this.characterToValueMap = new Map()
        for (var i = 0; i < CHARACTER_LOOKUP.length; i++) {
            this.characterToValueMap[CHARACTER_LOOKUP[i]] = i
        }
        this.characterToValueMap.getOrDefault = function(key, value) {
          if (this[key]) return this[key]
          return value
        }
  }

  encode(stringObject) {
        // Get the prefix array from the type and the content array from the content object.
        const prefixBytes = NYZO_PREFIXES_BYTES[stringObject.getType()]
        const contentBytes = stringObject.getBytes()

        // Determine the length of the expanded array with the header and the checksum. The header is the type-specific
        // prefix in characters followed by a single byte that indicates the length of the content array (four bytes
        // total). The checksum is a minimum of 4 bytes and a maximum of 6 bytes, widening the expanded array so that
        // its length is divisible by 3.
        const checksumLength = 4 + (3 - (contentBytes.length + 2) % 3) % 3
        const expandedLength = HEADER_LENGTH + contentBytes.length + checksumLength

        // Create the array and add the header and the content. The first three bytes turn into the user-readable
        // prefix in the encoded string. The next byte specifies the length of the content array, and it is immediately
        // followed by the content array.
        let prefixBuffer = Buffer.alloc(prefixBytes.length + 1)
        let i
        for (i = 0; i < prefixBytes.length; i++) {
            prefixBuffer[i] = prefixBytes[i]
        }
        prefixBuffer[i++] = contentBytes.length
        let contentBuffer = Buffer.concat([prefixBuffer, Buffer.from(contentBytes)])
        // TODO: run benchmarks to check if we loose much by concat instead of defining the full buffer first then copy the parts.
        // See Buffer.copy https://nodejs.org/en/knowledge/advanced/buffers/how-to-use-buffers/
        // https://nodejs.org/api/buffer.html#buffer_buf_copy_target_targetstart_sourcestart_sourceend
        // Compute the checksum and add the appropriate number of bytes to the end of the array.
        const checksum = createHash('sha256').update(createHash('sha256').update(contentBuffer).digest()).digest()
        const expandedBuffer = Buffer.concat([contentBuffer, checksum], expandedLength)

        // Build and return the encoded string from the expanded array.
        return this.encodedStringForByteArray(expandedBuffer)
    }

  decode(encodedString) {
      let result = null
        try {
            // Map characters from the old encoding to the new encoding. A few characters were changed to make Nyzo
            // strings more URL-friendly.
            encodedString = encodedString.replace('*', '-').replace('+', '.').replace('=', '~')
            // Map characters that may be mistyped. Nyzo strings contain neither 'l' nor 'O'.
            encodedString = encodedString.replace('l', '1').replace('O', '0')
            // Get the type from the prefix. Here, type is the 4 char prefix as string.
            const type = encodedString.substring(0, 4)
            // If the type is valid, continue.
            if (NYZO_PREFIXES.includes(type)) {
                // Get the array representation of the encoded string.
                const expandedArray = this.byteArrayForEncodedString(encodedString)
                // Get the content length from the next byte and calculate the checksum length.
                const contentLength = expandedArray[3] & 0xff
                const checksumLength = expandedArray.length - contentLength - 4
                // Only continue if the checksum length is valid.
                if (checksumLength >= 4 && checksumLength <= 6) {
                    // Calculate the checksum and compare it to the provided checksum.
                    // Only create the result array if the checksums match.
                    const contentBuffer = Buffer.from(expandedArray.slice(0, HEADER_LENGTH + contentLength))
                    const fullCalculatedChecksum = createHash('sha256').update(createHash('sha256').update(contentBuffer).digest()).digest()
                    const calculatedChecksum = fullCalculatedChecksum.slice(0,checksumLength)
                    const providedChecksum = Buffer.from(expandedArray.slice(expandedArray.length - checksumLength, expandedArray.length))
                    if (providedChecksum.equals(calculatedChecksum)) {
                        // Get the content array. This is the encoded object with the prefix, length byte, and checksum
                        // removed.
                        const contentBytes = Buffer.from(expandedArray.slice(HEADER_LENGTH, expandedArray.length - checksumLength))
                        // Make the object from the content array.
                        switch (type) {
                            case 'pre_':
                                result = NyzoStringPrefilledData.fromByteBuffer(contentBytes)
                                break
                            case 'key_':
                                result = new NyzoStringPrivateSeed(contentBytes)
                                break
                            case 'id__':
                                result = new NyzoStringPublicIdentifier(contentBytes)
                                break
                            case 'pay_':
                                result = NyzoStringMicropay.fromByteBuffer(contentBytes)
                                break
                            case 'tx__':
                                result = NyzoStringTransaction.fromByteBuffer(contentBytes)
                                break
                            case 'sig_':
                                result = new NyzoStringSignature(contentBytes)
                                break
                        }
                    }
                }
            }
        } catch (ignored) {
            console.log(ignored)  // debug
        }

        return result
  }

  byteArrayForEncodedString(encodedString) {
        const arrayLength = (encodedString.length * 6 + 7) / 8
        let array = new Uint8Array(arrayLength)
        for (var i = 0; i < arrayLength; i++) {
            const leftCharacter = encodedString.charAt(i * 8 / 6)
            const rightCharacter = encodedString.charAt(i * 8 / 6 + 1)
            const leftValue = this.characterToValueMap.getOrDefault(leftCharacter, 0)
            const rightValue = this.characterToValueMap.getOrDefault(rightCharacter, 0)
            const bitOffset = (i * 2) % 6
            array[i] = ((((leftValue << 6) + rightValue) >> 4 - bitOffset) & 0xff)
        }
        return array
  }

  encodedStringForByteArray(array) {
        let index = 0
        let bitOffset = 0
        let encodedString = ''
        while (index < array.length) {
            // Get the current and next byte.
            const leftByte = array[index] & 0xff
            const rightByte = index < array.length - 1 ? array[index + 1] & 0xff : 0
            // Append the character for the next 6 bits in the array.
            const lookupIndex = (((leftByte << 8) + rightByte) >> (10 - bitOffset)) & 0x3f
            encodedString += CHARACTER_LOOKUP[lookupIndex]
            // Advance forward 6 bits.
            if (bitOffset == 0) {
                bitOffset = 6
            } else {
                index++
                bitOffset -= 2
            }
        }
        return encodedString
  }

}

// This is the instance to be used
nyzoStringEncoder = new NyzoStringEncoder()


module.exports = {
    version: "0.0.4",
    NyzoStringEncoder,
    nyzoStringEncoder
}
