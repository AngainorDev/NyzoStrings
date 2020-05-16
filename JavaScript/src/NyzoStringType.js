// kept for reference to java code, but deprecated for JS use.

console.log("Warning: NyzoStringType should not be used in production, deprecated for JS implementation.")

const { nyzoStringEncoder } = require('./NyzoStringEncoder')


const NyzoTypes = {
    PrefilledData: 'pre_',
    PrivateSeed: 'key_',
    PublicIdentifier: 'id__',
    Micropay: 'pay_',
    Transaction: 'tx__'
}

const NyzoPrefixesBytes = {
    'pre_': new Uint8Array([97, 163, 191]),
    'key_': new Uint8Array([80, 232, 227]),
    'id__': new Uint8Array([72, 223, 255]),
    'pay_': new Uint8Array([96, 168, 127]),
    'tx__': new Uint8Array([114, 15, 255]),
    'sig_': new Uint8Array([0x6d,0x24,0x3f])
}

class NyzoStringType {

  constructor(prefix) {
    this.prefix = prefix
    this.prefixBytes = nyzoStringEncoder.byteArrayForEncodedString(prefix)
  }

  getPrefix() {
    return this.prefix
  }

  getPrefixBytes() {
    return this.prefixBytes
  }

  static forPrefix(prefix) {
        result = null
        for (const [key, value] of Object.entries(NyzoTypes)) {
            if (value.equals(prefix)) {
                result = type
            }
        }
        return result;
    }

  static BytesForPrefix(prefix) {
    return NyzoPrefixesBytes[prefix]
  }

  static forType(aType) {
        return new NyzoStringType(NyzoTypes[aType])
  }


 }


module.exports = {
    version: "0.0.1",
    NyzoTypes,
    NyzoStringType
}
