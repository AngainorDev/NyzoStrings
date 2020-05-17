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

const voteYes = 1
const voteNo = 0

class NyzoStringTransaction extends NyzoString {

  constructor(txType, timestamp, amount, receiverIdentifier, previousHashHeight, previousBlockHash, senderIdentifier, senderData, signature, vote, transactionSignature) {
    if (txType==2) {  // typeStandard
        senderData = senderData.slice(0, 32)
        const senderDataLength = senderData.length
        // 1(type) +  8        8           32                  8                   32/ignored           32         1 + len      64
        let bytes = Buffer.alloc(1 + 8 + 8 + 32 + 8 + 32 + 1 + senderDataLength + 64)
        bytes[0] = txType
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
    } else if (txType==4) {  // typeCycleSignature
        // 1(type) +  8 (timestamp)  + 32(signer) + 1 (vote) + 64 (txsignature) + 64 (sig)
        let bytes = Buffer.alloc(1 + 8 + 32 + 1 + 64 + 64)
        bytes[0] = txType
        timestamp.copy(bytes, 1)
        Buffer.from(senderIdentifier).copy(bytes, 1 + 8)
        bytes[1 + 8 + 32] = vote
        Buffer.from(transactionSignature).copy(bytes, 1 + 8 + 32 + 1)
        Buffer.from(signature).copy(bytes,  1 + 8 + 32 + 1 + 64)
        super('tx__', bytes)

        this.timestamp = timestamp
        this.senderIdentifier = senderIdentifier
        this.vote = vote
        this.transactionSignature = transactionSignature
        this.signature = signature
    } else {
        throw("Unsupported transaction type " + txType.toString())
    }
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
    const txType = buffer.slice(index, index + 1).readInt8()  // Ignored - only supports type 2, standard transaction
    index += 1
    if (txType == 2) {
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
        return new NyzoStringTransaction(txType, timestamp, amount, receiverBuffer, previousHashHeight, previousBlockHash, senderBuffer, dataBuffer, signatureBuffer)
    } else if (txType == 4) {
        const timestamp = new Int64(buffer.slice(index, index + 8))
        index += 8
        const senderBuffer = buffer.slice(index, index + 32)
        index += 32
        const vote = buffer[index] & 0xff
        index += 1
        const transactionSignatureBuffer = buffer.slice(index, index + 64)
        index += 64
        const signatureBuffer = buffer.slice(index, index + 64)

        const amount = 0 // new Int64(amountHex)
        const receiverBuffer = new Buffer(0) // Buffer.from(filteredString, 'hex')
        const previousHashHeight = 0
        const dataBuffer = new Buffer(0) //Buffer.from(dataHex, 'hex')
        const previousBlockHash = new Buffer(0)
        return new NyzoStringTransaction(txType, timestamp, amount, receiverBuffer, previousHashHeight, previousBlockHash, senderBuffer, dataBuffer, signatureBuffer, vote, transactionSignatureBuffer)

    } else {
        throw ("Unsupported Transaction type" + txType.toString())
    }
  }

  static fromHex(timestampHex, amountHex, receiverHex, previousHashHeightHex, previousBlockHashHex, senderHex, dataHex, signatureHex ) {
    // Type 2 only
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
    return new NyzoStringTransaction(2, timestamp, amount, receiverBuffer, previousHashHeight, previousBlockHashBuffer, senderBuffer, dataBuffer, signatureBuffer)
  }

  static fromHexVote(timestampHex, senderHex, signatureHex, vote, transactionSignatureHex) {
    const timestamp = new Int64(timestampHex)
    const amount = 0 // new Int64(amountHex)
    //const filteredString = receiverHex.split('-').join('').slice(0, 64)
    const receiverBuffer = new Buffer(0) // Buffer.from(filteredString, 'hex')
    const previousHashHeight = 0
    const previousBlockHashBuffer = new Buffer(0) //Buffer.from(filteredHash, 'hex')
    const filteredSender = senderHex.split('-').join('').slice(0, 64)
    const senderBuffer = Buffer.from(filteredSender, 'hex')
    const dataBuffer = new Buffer(0) //Buffer.from(dataHex, 'hex')
    const signatureBuffer = Buffer.from(signatureHex, 'hex')
    const transactionSignatureBuffer = Buffer.from(transactionSignatureHex, 'hex')
    return new NyzoStringTransaction(4, timestamp, amount, receiverBuffer, previousHashHeight, previousBlockHashBuffer, senderBuffer, dataBuffer, signatureBuffer, vote, transactionSignatureBuffer)
  }


}


module.exports = {
    version: "0.0.2",
    NyzoStringTransaction
}
