"""
Nyzo String for Prefilled Data
"""

from nyzostrings.nyzostring import NyzoString


__version__ = "0.0.1"


class NyzoStringPrefilledData(NyzoString):
    def __init__(
        self,
        receiver_identifier: bytes,
        sender_data: bytes,
    ) -> None:
        sender_data = sender_data[:32]
        sender_data_len = len(sender_data)
        bytes_content = bytearray(32 + 1 + sender_data_len)
        bytes_content[0:32] = receiver_identifier
        bytes_content[32] = sender_data_len
        bytes_content[33 : 33 + sender_data_len] = sender_data
        super().__init__("pre_", bytes_content)
        self.receiver_identifier = receiver_identifier
        self.sender_data = sender_data

    @classmethod
    def from_bytes(cls, byte_buffer: bytes) -> "NyzoStringPrefilledData":
        buffer = memoryview(byte_buffer)
        receiver_buffer = buffer[:32]
        sender_data_length = min(buffer[32] & 0xFF, 32)
        data_buffer = buffer[33 : 33 + sender_data_length]
        return NyzoStringPrefilledData(
            receiver_buffer,
            data_buffer
        )

    @classmethod
    def from_hex(
        cls,
        receiver_identifier_hex: str,
        sender_data_hex: str,
    ) -> "NyzoStringPrefilledData":
        filtered_string = receiver_identifier_hex.replace("-", "")[:64]
        receiver = bytes.fromhex(filtered_string)
        filtered_string = sender_data_hex.replace("-", "")[:64]
        data = bytes.fromhex(filtered_string)
        return NyzoStringPrefilledData(receiver, data)
