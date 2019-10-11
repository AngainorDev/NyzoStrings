// ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoString.java


class NyzoString {
  // Common ancestor

  constructor(type, bytes) {
    this.type = type
    this.bytes = bytes
  }

  getType() {
    return this.type
  }

  getBytes() {
    return this.bytes
  }

}


module.exports = {
    version: "0.0.1",
    NyzoString
}
