"""
Nyzo String for private Seed
"""

from nyzostrings.nyzostring import NyzoString


__version__ = "0.0.1"


class NyzoStringMicropay(NyzoString):
    def __init__(
        self,
        receiver_identifier: bytes,
        sender_data: bytes,
        amount: int,
        timestamp: int,
        previous_hash_height: int,
        previous_block_hash: bytes,
    ) -> None:
        sender_data = sender_data[:32]
        sender_data_len = len(sender_data)
        bytes_content = bytearray(32 + 1 + sender_data_len + 8 + 8 + 8 + 32)
        bytes_content[0:32] = receiver_identifier
        bytes_content[32] = sender_data_len
        bytes_content[33 : 33 + sender_data_len] = sender_data
        bytes_content[
            33 + sender_data_len : 33 + sender_data_len + 8
        ] = amount.to_bytes(8, byteorder="big")
        bytes_content[
            33 + sender_data_len + 8 : 33 + sender_data_len + 8 + 8
        ] = timestamp.to_bytes(8, byteorder="big")
        bytes_content[
            33 + sender_data_len + 8 + 8 : 33 + sender_data_len + 8 + 8 + 8
        ] = previous_hash_height.to_bytes(8, byteorder="big")
        bytes_content[
            33 + sender_data_len + 8 + 8 + 8 : 33 + sender_data_len + 8 + 8 + 8 + 32
        ] = previous_block_hash
        super().__init__("pay_", bytes_content)
        self.receiver_identifier = receiver_identifier
        self.sender_data = sender_data
        self.amount = amount
        self.timestamp = timestamp
        self.previous_hash_height = previous_hash_height
        self.previous_block_hash = previous_block_hash

    @classmethod
    def from_bytes(cls, byte_buffer: bytes) -> "NyzoStringMicropay":
        buffer = memoryview(byte_buffer)
        receiver_buffer = buffer[:32]
        sender_data_length = min(buffer[32] & 0xFF, 32)
        data_buffer = buffer[33 : 33 + sender_data_length]
        amount = int.from_bytes(
            buffer[33 + sender_data_length : 33 + sender_data_length + 8],
            byteorder="big",
            signed=False,
        )
        timestamp = int.from_bytes(
            buffer[33 + sender_data_length + 8 : 33 + sender_data_length + 8 + 8],
            byteorder="big",
            signed=False,
        )
        previous_hash_height = int.from_bytes(
            buffer[
                33 + sender_data_length + 8 + 8 : 33 + sender_data_length + 8 + 8 + 8
            ],
            byteorder="big",
            signed=False,
        )
        previous_block_hash_buffer = buffer[
            33
            + sender_data_length
            + 8
            + 8
            + 8 : 33
            + sender_data_length
            + 8
            + 8
            + 8
            + 32
        ]
        return NyzoStringMicropay(
            receiver_buffer,
            data_buffer,
            amount,
            timestamp,
            previous_hash_height,
            previous_block_hash_buffer,
        )

    @classmethod
    def from_hex(
        cls,
        receiver_identifier_hex: str,
        sender_data_hex: str,
        amount_hex: str,
        timestamp_hex: str,
        previous_hash_height_hex: str,
        previous_block_hash_hex: str,
    ) -> "NyzoStringMicropay":
        filtered_string = receiver_identifier_hex.replace("-", "")[:64]
        receiver = bytes.fromhex(filtered_string)
        filtered_string = sender_data_hex.replace("-", "")[:64]
        data = bytes.fromhex(filtered_string)
        amount = int(amount_hex, 16)
        timestamp = int(timestamp_hex, 16)
        previous_hash_height = int(previous_hash_height_hex, 16)
        filtered_string = previous_block_hash_hex.replace("-", "")[:64]
        previous_block_hash = bytes.fromhex(filtered_string)
        return NyzoStringMicropay(
            receiver, data, amount, timestamp, previous_hash_height, previous_block_hash
        )
