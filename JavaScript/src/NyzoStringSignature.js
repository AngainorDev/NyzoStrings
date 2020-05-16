// ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringSignature.java

const { NyzoString } = require('./NyzoString')


class NyzoStringSignature extends NyzoString {

  constructor(identifier) {
    super('sig_', identifier)
  }

  getIdentifier() {
        return this.bytes
  }

  static fromHex(hexString) {
    const filteredString = hexString.split('-').join('').slice(0, 128)
    const buffer = Buffer.from(filteredString, 'hex')
    return new NyzoStringSignature(buffer)
  }

}


module.exports = {
    version: "0.0.1",
    NyzoStringSignature
}
