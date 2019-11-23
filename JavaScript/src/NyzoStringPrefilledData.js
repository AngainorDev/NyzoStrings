// https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringPrefilledData.java

const { NyzoString } = require('./NyzoString')


class NyzoStringPrefilledData extends NyzoString {

  constructor(receiverIdentifier, senderData) {
    senderData = senderData.slice(0, 32)
    let bytes = Buffer.alloc(32 + 1 + senderData.length)
    Buffer.from(receiverIdentifier).copy(bytes, 0)
    bytes[32] = senderData.length
    Buffer.from(senderData).copy(bytes, 33)
    super('pre_', bytes)
    this.receiverIdentifier = receiverIdentifier
    this.senderData = senderData
  }

  getReceiverIdentifier() {
        return this.receiverIdentifier
  }

  getSenderData() {
        return this.senderData
  }

  static fromByteBuffer(buffer) {
    const receiverBuffer = buffer.slice(0, 32)
    const senderDataLength = Math.min(buffer[32] & 0xff, 32)
    const dataBuffer = buffer.slice(33, 33 + senderDataLength)
    return new NyzoStringPrefilledData(receiverBuffer, dataBuffer)
  }

  static fromHex(receiverHexString, dataHexString) {
    const filteredString = receiverHexString.split('-').join('').slice(0, 64)
    const receiverBuffer = Buffer.from(filteredString, 'hex')
    const dataBuffer = Buffer.from(dataHexString, 'hex')
    return new NyzoStringPrefilledData(receiverBuffer, dataBuffer)
  }

}


module.exports = {
    version: "0.0.1",
    NyzoStringPrefilledData
}
