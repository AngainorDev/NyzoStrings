// https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringPrefilledData.java

const { NyzoString } = require('./NyzoString')
// JS does not support native int64
const Int64 = require('node-int64')


class NyzoStringPrefilledData extends NyzoString {

  constructor(receiverIdentifier, senderData, amount) {
    // Amount is expected as Int64
    senderData = senderData.slice(0, 32)
    let bufferLen = 32 + 1 + senderData.length
    if (amount == null) {
        amount = new Int64(0)
    }
    if (amount > 0) {
        bufferLen += 8
    }
    let bytes = Buffer.alloc(bufferLen)
    Buffer.from(receiverIdentifier).copy(bytes, 0)
    bytes[32] = senderData.length
    Buffer.from(senderData).copy(bytes, 33)
    if (amount > 0) {
        bytes[32] |= 0b10000000
        amount.copy(bytes, 33 + senderData.length)
    }
    super('pre_', bytes)
    this.receiverIdentifier = receiverIdentifier
    this.senderData = senderData
    this.amount = amount
  }

  getReceiverIdentifier() {
        return this.receiverIdentifier
  }

  getSenderData() {
        return this.senderData
  }

  getAmount() {
        // This returns an Int64
        return this.amount
  }

  static fromByteBuffer(buffer) {
    const receiverBuffer = buffer.slice(0, 32)
    const senderDataLength = Math.min(buffer[32] & 0b00111111, 32)
    const dataBuffer = buffer.slice(33, 33 + senderDataLength)
    let amount = new Int64(0)
    if ((buffer[32] & 0b10000000) == 0b10000000) {
        // Amount was encoded
        amount = new Int64(buffer.slice(33 + senderDataLength, 33 + senderDataLength + 8))
    }
    return new NyzoStringPrefilledData(receiverBuffer, dataBuffer, amount)
  }

  static fromHex(receiverHexString, dataHexString, amount) {
    // Amount is expected as Int64
    const filteredString = receiverHexString.split('-').join('').slice(0, 64)
    const receiverBuffer = Buffer.from(filteredString, 'hex')
    const dataBuffer = Buffer.from(dataHexString, 'hex')
    return new NyzoStringPrefilledData(receiverBuffer, dataBuffer, amount)
  }

}


module.exports = {
    version: "0.0.2",
    NyzoStringPrefilledData
}
