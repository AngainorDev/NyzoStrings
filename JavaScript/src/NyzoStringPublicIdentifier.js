// ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringPublicIdentifier.java

const { NyzoString } = require('./NyzoString')


class NyzoStringPublicIdentifier extends NyzoString {

  constructor(identifier) {
    super('id__', identifier)
  }

  getIdentifier() {
        return this.bytes
  }

  static fromHex(hexString) {
    const filteredString = hexString.split('-').join('').slice(0, 64)
    const buffer = Buffer.from(filteredString, 'hex')
    return new NyzoStringPublicIdentifier(buffer)
  }

}


module.exports = {
    version: "0.0.1",
    NyzoStringPublicIdentifier
}
