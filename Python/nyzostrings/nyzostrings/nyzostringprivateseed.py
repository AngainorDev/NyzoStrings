"""
Nyzo String for private Seed
"""

from nyzostrings.nyzostring import NyzoString


__version__ = "0.0.1"


class NyzoStringPrivateSeed(NyzoString):

    def __init__(self, identifier: bytes) -> None:
        super().__init__('key_', identifier)

    def get_seed(self) -> bytes:
        return self.bytes_content

    @classmethod
    def from_hex(cls, hex_string: str) -> "NyzoStringPrivateSeed":
        filtered_string = hex_string.replace('-', '')[:64]
        return NyzoStringPrivateSeed(bytes.fromhex(filtered_string))
