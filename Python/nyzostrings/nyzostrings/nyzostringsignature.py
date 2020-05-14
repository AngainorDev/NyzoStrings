"""
Nyzo String for publicIdentifier
"""

from nyzostrings.nyzostring import NyzoString


__version__ = "0.0.1"


class NyzoStringSignature(NyzoString):

    def __init__(self, signature: bytes) -> None:
        super().__init__('sig_', signature)

    def get_identifier(self) -> bytes:
        return self.bytes_content

    @classmethod
    def from_hex(cls, hex_string: str) -> "NyzoStringSignature":
        filtered_string = hex_string.replace('-', '')[:128]
        return NyzoStringSignature(bytes.fromhex(filtered_string))


