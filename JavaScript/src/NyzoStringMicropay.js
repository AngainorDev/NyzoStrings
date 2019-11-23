// https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringPrefilledData.java

// JS does not support native int64
// An alternative could be https://www.npmjs.com/package/int64-buffer
// Maybe smaller
const Int64 = require('node-int64')

const { NyzoString } = require('./NyzoString')

class NyzoStringMicropay extends NyzoString {

  constructor(receiverIdentifier, senderData, amount, timestamp, previousHashHeight, previousBlockHash) {
    senderData = senderData.slice(0, 32)
    let bytes = Buffer.alloc(32 + 1 + senderData.length + 8 + 8 + 8 + 32)
    Buffer.from(receiverIdentifier).copy(bytes, 0)
    bytes[32] = senderData.length
    Buffer.from(senderData).copy(bytes, 33)
    amount.copy(bytes, 33 + senderData.length)
    timestamp.copy(bytes, 33 + senderData.length + 8)
    previousHashHeight.copy(bytes, 33 + senderData.length + 8 + 8)
    Buffer.from(previousBlockHash).copy(bytes, 33 + senderData.length + 8 + 8 + 8)
    super('pay_', bytes)
    this.receiverIdentifier = receiverIdentifier
    this.senderData = senderData
    this.amount = amount
    this.timestamp = timestamp
    this.previousHashHeight = previousHashHeight
    this.previousBlockHash = previousBlockHash
  }

  getReceiverIdentifier() {
      return this.receiverIdentifier
  }

  getSenderData() {
      return this.senderData
  }

  getAmount() {
      return this.amount
  }

  getTimestamp() {
      return this.timestamp
  }

  getPreviousHashHeight() {
      return this.previousHashHeight
  }

  getPreviousBlockHash() {
      return this.previousBlockHash
  }

  static fromByteBuffer(buffer) {
    const receiverBuffer = buffer.slice(0, 32)
    const senderDataLength = Math.min(buffer[32] & 0xff, 32)
    const dataBuffer = buffer.slice(33, 33 + senderDataLength)
    const amount = new Int64(buffer.slice(33 + senderDataLength, 33 + senderDataLength + 8))
    const timestamp = new Int64(buffer.slice(33 + senderDataLength + 8, 33 + senderDataLength + 8 + 8))
    const previousHashHeight = new Int64(buffer.slice(33 + senderDataLength + 8 + 8, 33 + senderDataLength + 8 + 8 + 8))
    const previousBlockHashBuffer = buffer.slice(33 + senderDataLength + 8 + 8 + 8, 33 + senderDataLength + 8 + 8 + 8 + 32)
    return new NyzoStringMicropay(receiverBuffer, dataBuffer, amount, timestamp, previousHashHeight, previousBlockHashBuffer)
  }

  static fromHex(receiverHexString, dataHexString, amountHex, timestampHex, previousHashHeightHex, previousBlockHashBufferHex) {
    const filteredString = receiverHexString.split('-').join('').slice(0, 64)
    const receiverBuffer = Buffer.from(filteredString, 'hex')
    const dataBuffer = Buffer.from(dataHexString, 'hex')
    const amount = new Int64(amountHex)
    const timestamp = new Int64(timestampHex)
    const previousHashHeight = new Int64(previousHashHeightHex)
    const filteredHash = previousBlockHashBufferHex.split('-').join('').slice(0, 64)
    const previousBlockHashBuffer = Buffer.from(filteredHash, 'hex')
    return new NyzoStringMicropay(receiverBuffer, dataBuffer, amount, timestamp, previousHashHeight, previousBlockHashBuffer)
  }

}


module.exports = {
    version: "0.0.1",
    NyzoStringMicropay
}
