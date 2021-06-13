"""
Nyzo String for Prefilled Data
"""

from nyzostrings.nyzostring import NyzoString


__version__ = "0.0.2"


class NyzoStringPrefilledData(NyzoString):
    def __init__(
        self,
        receiver_identifier: bytes,
        sender_data: bytes,
        amount: int = 0  # Unit is integer, micronyzo
    ) -> None:
        sender_data = sender_data[:32]
        sender_data_len = len(sender_data)
        buf_len = 32 + 1 + sender_data_len
        if amount > 0:
            # Add amount
            buf_len += 8
        bytes_content = bytearray(buf_len)
        bytes_content[0:32] = receiver_identifier
        bytes_content[32] = sender_data_len
        bytes_content[33: 33 + sender_data_len] = sender_data
        if amount > 0:
            bytes_content[32] |= 0b10000000
            bytes_content[33 + sender_data_len: 33 + sender_data_len + 8] = amount.to_bytes(8, byteorder="big")
        super().__init__("pre_", bytes_content)
        self.receiver_identifier = receiver_identifier
        self.sender_data = sender_data
        self.amount = amount

    @classmethod
    def from_bytes(cls, byte_buffer: bytes) -> "NyzoStringPrefilledData":
        buffer = memoryview(byte_buffer)
        receiver_buffer = buffer[:32]
        amount = 0
        sender_data_length = min(buffer[32] & 0b00111111, 32)
        data_buffer = buffer[33: 33 + sender_data_length]
        if buffer[32] & 0b10000000 == 0b10000000:
            # Amount was encoded
            amount = int.from_bytes(
                buffer[33 + sender_data_length: 33 + sender_data_length + 8], byteorder="big", signed=False
            )
        return NyzoStringPrefilledData(
            receiver_buffer,
            data_buffer,
            amount
        )

    @classmethod
    def from_hex(
        cls,
        receiver_identifier_hex: str,
        sender_data_hex: str,
        amount: int=0
    ) -> "NyzoStringPrefilledData":
        filtered_string = receiver_identifier_hex.replace("-", "")[:64]
        receiver = bytes.fromhex(filtered_string)
        filtered_string = sender_data_hex.replace("-", "")[:64]
        data = bytes.fromhex(filtered_string)
        return NyzoStringPrefilledData(receiver, data, amount)
