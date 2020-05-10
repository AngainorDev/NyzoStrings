"""
Nyzo String encoder

ref: https://github.com/n-y-z-o/nyzoVerifier/blob/master/src/main/java/co/nyzo/verifier/nyzoString/NyzoStringEncoder.java
ref: js impl
"""

from hashlib import sha256
from nyzostrings.nyzostring import NyzoString
from nyzostrings.nyzostringpublicidentifier import NyzoStringPublicIdentifier
from nyzostrings.nyzostringsignature import NyzoStringSignature
from nyzostrings.nyzostringprivateseed import NyzoStringPrivateSeed
from nyzostrings.nyzostringmicropay import NyzoStringMicropay
from nyzostrings.nyzostringprefilleddata import NyzoStringPrefilledData
from nyzostrings.nyzostringtransaction import NyzoStringTransaction


__version__ = "0.0.5"


CHARACTER_LOOKUP = (
    "0123456789"
    + "abcdefghijkmnopqrstuvwxyz"  # all except lowercase "L"
    + "ABCDEFGHIJKLMNPQRSTUVWXYZ"  # all except uppercase "o"
    + "-.~_"
)


# From JS code
NYZO_PREFIXES_BYTES = {
    "pre_": bytes([97, 163, 191]),
    "key_": bytes([80, 232, 127]),
    "id__": bytes([72, 223, 255]),
    "pay_": bytes([96, 168, 127]),
    "tx__": bytes([114, 15, 255]),
    "sig_": bytes([0x6d,0x24,0x3f]),
}

# Get a list of valid prefixes for future use.
NYZO_PREFIXES = NYZO_PREFIXES_BYTES.keys()

HEADER_LENGTH = 4

CHARACTER_TO_VALUE = {}

# Init reverse index
for i, char in enumerate(CHARACTER_LOOKUP):
    CHARACTER_TO_VALUE[CHARACTER_LOOKUP[i]] = i


class NyzoStringEncoder:
    @classmethod
    def encode(cls, string_object: NyzoString) -> str:
        # Get the prefix array from the type and the content array from the content object.
        prefix_bytes = NYZO_PREFIXES_BYTES[string_object.get_type()]
        content_bytes = string_object.get_bytes()
        content_bytes_len = len(content_bytes)
        """ Determine the length of the expanded array with the header and the checksum. The header is the type-specific
        prefix in characters followed by a single byte that indicates the length of the content array (four bytes
        total). The checksum is a minimum of 4 bytes and a maximum of 6 bytes, widening the expanded array so that
        its length is divisible by 3.
        """
        checksum_length = 4 + (3 - (content_bytes_len + 2) % 3) % 3
        expanded_length = HEADER_LENGTH + content_bytes_len + checksum_length
        """ Create the array and add the header and the content. The first three bytes turn into the user-readable
        prefix in the encoded string. The next byte specifies the length of the content array, and it is immediately
        followed by the content array.
        """
        expanded_buffer = bytearray(expanded_length)
        expanded_buffer[0:3] = prefix_bytes
        expanded_buffer[3] = content_bytes_len
        expanded_buffer[4:4 + content_bytes_len] = content_bytes
        content_view = memoryview(expanded_buffer)[: 4 + content_bytes_len]
        checksum = sha256(sha256(content_view).digest()).digest()[:checksum_length]
        expanded_buffer[4 + content_bytes_len :] = checksum
        return cls.encoded_string_for_bytes(expanded_buffer)

    @classmethod
    def decode(cls, encoded_string: str) -> NyzoString:
        result = None
        try:
            # Map characters from the old encoding to the new encoding. A few characters were changed to make Nyzo
            # strings more URL-friendly.
            encoded_string = encoded_string.replace('*', '-').replace('+', '.').replace('=', '~')
            # Map characters that may be mistyped. Nyzo strings contain neither 'l' nor 'O'.
            encoded_string = encoded_string.replace('l', '1').replace('O', '0')
            # Get the type from the prefix. Here, type is the 4 char prefix as string.
            string_type = encoded_string[:4]
            # If the type is valid, continue.
            if string_type in NYZO_PREFIXES:
                # Get the array representation of the encoded string.
                expanded_array = cls.bytes_for_encoded_string(encoded_string)
                # print("x", expanded_array.hex())
                # Get the content length from the next byte and calculate the checksum length.
                content_length = expanded_array[3] & 0xff
                # print("content_length", content_length)
                checksum_length = len(expanded_array) - content_length - 4
                # print("checksum_length", checksum_length)
                # Only continue if the checksum length is valid.
                if 4 <= checksum_length <= 6:
                    # Calculate the checksum and compare it to the provided checksum.
                    # Only create the result array if the checksums match.
                    content_buffer = memoryview(expanded_array)[0:HEADER_LENGTH + content_length]
                    calculated_checksum = sha256(sha256(content_buffer).digest()).digest()[:checksum_length]
                    provided_checksum = memoryview(expanded_array)[-checksum_length:]
                    if provided_checksum.tobytes() == calculated_checksum:
                        # Get the content array. This is the encoded object with the prefix, length byte, and checksum
                        # removed.
                        content_bytes = memoryview(expanded_array)[HEADER_LENGTH:content_length + HEADER_LENGTH]
                        # print("Content", content_bytes.tobytes())
                        # Make the object from the content array.
                        if string_type == 'pre_':
                            result = NyzoStringPrefilledData.from_bytes(content_bytes)
                        elif string_type == 'key_':
                            result = NyzoStringPrivateSeed(content_bytes)
                        elif string_type == 'id__':
                            result = NyzoStringPublicIdentifier(content_bytes)
                        elif string_type == 'pay_':
                            result = NyzoStringMicropay.from_bytes(content_bytes)
                        elif string_type == 'tx__':
                            result = NyzoStringTransaction.from_bytes(content_bytes)
                        elif string_type == 'sig_':
                            result = NyzoStringSignature(content_bytes)
                    else:
                        print("Invalid checksum: <{}> vs calc <{}>".format(provided_checksum.tobytes(), provided_checksum))
                else:
                    print("Invalid checksum len: <{}>".format(checksum_length))
            else:
                print("Unknown String type: <{}>".format(string_type))
        except Exception as e:
            print("Exception decode: {}".format(e))  # debug

        return result


    @classmethod
    def bytes_for_encoded_string(cls, encoded_string: str) -> bytes:
        array_length = (len(encoded_string) * 6 + 7) // 8
        array = bytearray(array_length)
        for i in range(array_length):
            left_character = encoded_string[i * 8 // 6]
            right_character = encoded_string[i * 8 // 6 + 1]
            left_value = CHARACTER_TO_VALUE.get(left_character, 0)
            right_value = CHARACTER_TO_VALUE.get(right_character, 0)
            bit_offset = (i * 2) % 6
            array[i] = (((left_value << 6) + right_value) >> 4 - bit_offset) & 0xFF
        return array

    @classmethod
    def encoded_string_for_bytes(cls, array: bytes) -> str:
        index = 0
        bit_offset = 0
        encoded_string = ""
        while index < len(array):
            # Get the current and next byte.
            left_byte = array[index] & 0xFF
            right_byte = array[index + 1] & 0xFF if index < len(array) - 1 else 0
            # Append the character for the next 6 bits in the array.
            lookup_index = (((left_byte << 8) + right_byte) >> (10 - bit_offset)) & 0x3F
            encoded_string += CHARACTER_LOOKUP[lookup_index]
            # Advance forward 6 bits.
            if bit_offset == 0:
                bit_offset = 6
            else:
                index += 1
                bit_offset -= 2
        return encoded_string
