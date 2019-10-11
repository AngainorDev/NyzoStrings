// ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringEncoder.java
// We tried to sick close to he java impl, but circular references and differences in the languages lead to some differences.

const createHash = require('create-hash')


const CHARACTER_LOOKUP = "0123456789" +
            "abcdefghijkmnopqrstuvwxyz" +  // all except lowercase "L"
            "ABCDEFGHIJKLMNPQRSTUVWXYZ" +  // all except uppercase "o"
            //"*+=_").toCharArray();       // old encoding, less URL-friendly
            "-.~_"                         // see https://tools.ietf.org/html/rfc3986#section-2.3

// These were computed once by he test suite, then hardcoded here so NyzoStringType is not needed in real code.
const NYZO_PREFIXES_BYTES = {
    'pre_': new Uint8Array([97, 163, 191]),
    'key_': new Uint8Array([80, 232, 227]),
    'id__': new Uint8Array([72, 223, 255]),
    'pay_': new Uint8Array([96, 168, 127]),
    'tx__': new Uint8Array([114, 15, 255]),
}

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
        // Compute the checksum and add the appropriate number of bytes to the end of the array.
        const checksum = createHash('sha256').update(createHash('sha256').update(contentBuffer).digest()).digest()
        const expandedBuffer = Buffer.concat([contentBuffer, checksum], expandedLength)

        // Build and return the encoded string from the expanded array.
        return this.encodedStringForByteArray(expandedBuffer)
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

nyzoStringEncoder = new NyzoStringEncoder()


module.exports = {
    version: "0.0.2",
    NyzoStringEncoder,
    nyzoStringEncoder
}
