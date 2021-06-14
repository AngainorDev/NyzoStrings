"""
Nyzo String for transaction
"""

from nyzostrings.nyzostring import NyzoString


__version__ = "0.0.3"


class NyzoStringTransaction(NyzoString):
    def __init__(
        self,
        tx_type: int,
        timestamp: int,
        amount: int,
        receiver_identifier: bytes,
        previous_hash_height: int,
        previous_block_hash: bytes,
        sender_identifier: bytes,
        sender_data: bytes,
        signature: bytes,
        vote: int = 0,
        transaction_signature: bytes = b''
    ) -> None:
        index = 0
        if tx_type == 2:
            sender_data = sender_data[:32]
            sender_data_len = len(sender_data)
            bytes_content = bytearray(1 + 8 + 8 + 32 + 8 + 32 + 1 + sender_data_len + 64)
            bytes_content[0] = 2  # Standard transaction
            index += 1
            bytes_content[index: index + 8] = timestamp.to_bytes(8, byteorder="big")
            index += 8
            bytes_content[index: index + 8] = amount.to_bytes(8, byteorder="big")
            index += 8
            bytes_content[index: index + 32] = receiver_identifier
            index += 32
            bytes_content[index: index + 8] = previous_hash_height.to_bytes(8, byteorder="big")
            index += 8
            bytes_content[index: index + 32] = sender_identifier
            index += 32
            bytes_content[index] = sender_data_len
            index += 1
            bytes_content[index: index + sender_data_len] = sender_data
            index += sender_data_len
            bytes_content[index: index + 64] = signature
            super().__init__("tx__", bytes_content)
            self.receiver_identifier = receiver_identifier
            self.sender_data = sender_data
            self.amount = amount
            self.timestamp = timestamp
            self.previous_hash_height = previous_hash_height
            self.previous_block_hash = previous_block_hash
        elif tx_type == 4:
            bytes_content = bytearray(1 + 8 + 32 + 1 + 64 + 64)
            bytes_content[0] = 4  # Vote tx
            index += 1
            bytes_content[index: index + 8] = timestamp.to_bytes(8, byteorder="big")
            index += 8
            bytes_content[index: index + 32] = sender_identifier
            index += 32
            bytes_content[1 + 8 + 32] = vote
            index += 1
            bytes_content[index: index + 64] = transaction_signature
            index += 64
            bytes_content[index: index + 64] = signature
            index += 64
            super().__init__("tx__", bytes_content)
            self.timestamp = timestamp
            self.senderIdentifier = sender_identifier
            self.vote = vote
            self.transactionSignature = transaction_signature
            self.signature = signature
        else:
            raise("Unsupported transaction type: {}".format(tx_type))

    @classmethod
    def from_bytes(cls, byte_buffer: bytes) -> "NyzoStringTransaction":
        buffer = memoryview(byte_buffer)
        index = 0
        tx_type = buffer[index]  # Ignored - only supports type 2, standard transaction
        index += 1
        if tx_type == 2:
            timestamp = int.from_bytes(
                buffer[index : index + 8], byteorder="big", signed=False
            )
            index += 8
            amount = int.from_bytes(
                buffer[index : index + 8], byteorder="big", signed=False
            )
            index += 8
            receiver_buffer = buffer[index : index + 32]
            index += 32
            previous_hash_height = int.from_bytes(
                buffer[index : index + 8], byteorder="big", signed=False
            )
            index += 8
            previous_block_hash = None
            sender_buffer = buffer[index : index + 32]
            index += 32
            sender_data_length = min(buffer[index] & 0xFF, 32)
            index += 1
            data_buffer = buffer[index : index + sender_data_length]
            index += sender_data_length
            signature_buffer = buffer[index : index + 64]
            return NyzoStringTransaction(
                tx_type,
                timestamp,
                amount,
                receiver_buffer,
                previous_hash_height,
                previous_block_hash,
                sender_buffer,
                data_buffer,
                signature_buffer,
            )
        elif tx_type == 4:
            timestamp = int.from_bytes(
                buffer[index: index + 8], byteorder="big", signed=False
            )
            index += 8
            sender_buffer = buffer[index: index + 32]
            index += 32
            vote = buffer[index] & 0xff
            index += 1
            transaction_signature_buffer = buffer[index: index + 64]
            index += 64
            signature_buffer = buffer[index: index + 64]
            index += 64
            return NyzoStringTransaction(
                tx_type,
                timestamp,
                0,
                b'',
                0,
                b'',
                sender_buffer,
                b'',
                signature_buffer,
                vote,
                transaction_signature_buffer
            )
        else:
            raise ("Unsupported transaction type: {}".format(tx_type))

    @classmethod
    def from_hex(
        cls,
        timestamp_hex: str,
        amount_hex: str,
        receiver_identifier_hex: str,
        previous_hash_height_hex: str,
        previous_block_hash_hex: str,
        sender_identifier_hex: str,
        data_hex: str,
        signature_hex: str,
    ) -> "NyzoStringTransaction":
        timestamp = int(timestamp_hex, 16)
        amount = int(amount_hex, 16)
        filtered_string = receiver_identifier_hex.replace("-", "")[:64]
        receiver_identifier = bytes.fromhex(filtered_string)
        previous_hash_height = int(previous_hash_height_hex, 16)
        filtered_string = previous_block_hash_hex.replace("-", "")[:64]
        previous_block_hash = bytes.fromhex(filtered_string)
        filtered_string = sender_identifier_hex.replace("-", "")[:64]
        sender_identifier = bytes.fromhex(filtered_string)
        filtered_string = data_hex.replace("-", "")[:64]
        sender_data = bytes.fromhex(filtered_string)
        filtered_string = signature_hex.replace("-", "")[:128]
        signature = bytes.fromhex(filtered_string)
        return cls(2, timestamp, amount, receiver_identifier, previous_hash_height,
                                     previous_block_hash, sender_identifier, sender_data, signature)

    @classmethod
    def from_hex_vote(
        cls,
        timestamp_hex: str,
        sender_identifier_hex: str,
        signature_hex: str,
        vote: int,
        transaction_signature_hex: str,
    ) -> "NyzoStringTransaction":
        timestamp = int(timestamp_hex, 16)
        amount = 0
        receiver_identifier = b''
        previous_hash_height = 0
        previous_block_hash = b''
        sender_data = b''
        filtered_string = sender_identifier_hex.replace("-", "")[:64]
        sender_identifier = bytes.fromhex(filtered_string)
        filtered_string = signature_hex.replace("-", "")[:128]
        signature = bytes.fromhex(filtered_string)
        filtered_string = transaction_signature_hex.replace("-", "")[:128]
        transaction_signature = bytes.fromhex(filtered_string)
        return NyzoStringTransaction(4, timestamp, amount, receiver_identifier, previous_hash_height,
                                     previous_block_hash, sender_identifier, sender_data, signature,
                                     vote, transaction_signature)
