// https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringTransaction.java
//
// WARNING: This implementation does significantly differ from the reference java code.
// Reference code uses a generic Transaction class that supports all transactions type.
// Test vectors, as well as this JS implementation, only supports the standard transaction type.

// JS does not support native int64
// An alternative could be https://www.npmjs.com/package/int64-buffer
// Maybe smaller
const Int64 = require('node-int64')

const { NyzoString } = require('./NyzoString')

class NyzoStringTransaction extends NyzoString {

  constructor(timestamp, amount, receiverIdentifier, previousHashHeight, previousBlockHash, senderIdentifier, senderData, signature) {
    senderData = senderData.slice(0, 32)
    const senderDataLength = senderData.length
    // 1(type) +  8        8           32                  8                   32/ignored           32         1 + len      64
    let bytes = Buffer.alloc(1 + 8 + 8 + 32 + 8 + 32 + 1 + senderDataLength + 64)
    bytes[0] = 2  // typeStandard
    timestamp.copy(bytes, 1)
    amount.copy(bytes, 1 + 8)
    Buffer.from(receiverIdentifier).copy(bytes, 1 + 8 + 8)
    previousHashHeight.copy(bytes, 1 + 8 + 8 + 32)
    Buffer.from(senderIdentifier).copy(bytes, 1 + 8 + 8 + 32 + 8)
    bytes[1 + 8 + 8 + 32 + 8 + 32] = senderData.length
    Buffer.from(senderData).copy(bytes, 1 + 8 + 8 + 32 + 8 + 32 + 1)
    Buffer.from(signature).copy(bytes,  1 + 8 + 8 + 32 + 8 + 32 + 1 + senderData.length)
    super('tx__', bytes)
    this.timestamp = timestamp
    this.amount = amount
    this.receiverIdentifier = receiverIdentifier
    this.previousHashHeight = previousHashHeight
    this.previousBlockHash = previousBlockHash
    this.senderIdentifier = senderIdentifier
    this.senderData = senderData
    this.signature = signature
  }

  getTimestamp() {
      return this.timestamp
  }

  getAmount() {
      return this.amount
  }

  getReceiverIdentifier() {
      return this.receiverIdentifier
  }

  getPreviousHashHeight() {
      return this.previousHashHeight
  }

  getPreviousBlockHash() {
      return this.previousBlockHash
  }

  getSenderIdentifier() {
      return this.senderIdentifier
  }

  getSenderData() {
      return this.senderData
  }

  getSignature() {
      return this.signature
  }

  static fromByteBuffer(buffer) {
    let index = 0
    const type = buffer.slice(index, index + 1)  // Ignored - only supports type 2, standard transaction
    index += 1
    const timestamp = new Int64(buffer.slice(index, index + 8))
    index += 8
    const amount = new Int64(buffer.slice(index, index + 8))
    index += 8
    const receiverBuffer = buffer.slice(index, index + 32)
    index += 32
    const previousHashHeight = new Int64(buffer.slice(index, index  +8))
    index += 8
    const previousBlockHash = null
    const senderBuffer = buffer.slice(index, index + 32)
    index += 32
    const senderDataLength = Math.min(buffer[index] & 0xff, 32)
    index += 1
    const dataBuffer = buffer.slice(index, index + senderDataLength)
    index += senderDataLength
    const signatureBuffer = buffer.slice(index, index + 64)

    return new NyzoStringTransaction(timestamp, amount, receiverBuffer, previousHashHeight, previousBlockHash, senderBuffer, dataBuffer, signatureBuffer)
  }

  static fromHex(timestampHex, amountHex, receiverHex, previousHashHeightHex, previousBlockHashHex, senderHex, dataHex, signatureHex ) {
    const timestamp = new Int64(timestampHex)
    const amount = new Int64(amountHex)
    const filteredString = receiverHex.split('-').join('').slice(0, 64)
    const receiverBuffer = Buffer.from(filteredString, 'hex')
    const previousHashHeight = new Int64(previousHashHeightHex)
    const filteredHash = previousBlockHashHex.split('-').join('').slice(0, 64)
    const previousBlockHashBuffer = Buffer.from(filteredHash, 'hex')
    const filteredSender = senderHex.split('-').join('').slice(0, 64)
    const senderBuffer = Buffer.from(filteredSender, 'hex')
    const dataBuffer = Buffer.from(dataHex, 'hex')
    const signatureBuffer = Buffer.from(signatureHex, 'hex')
    return new NyzoStringTransaction(timestamp, amount, receiverBuffer, previousHashHeight, previousBlockHashBuffer, senderBuffer, dataBuffer, signatureBuffer)
  }

}


module.exports = {
    version: "0.0.1",
    NyzoStringTransaction
}
