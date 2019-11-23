import sys

sys.path.append("../")
from nyzostrings.nyzostringmicropay import NyzoStringMicropay
from nyzostrings.nyzostringencoder import NyzoStringEncoder


def test_vector0():
    nyzo_string = NyzoStringMicropay.from_hex(
        "f786ad285a251faa-6b59b353b83b0cc7-5a5a9e53a99d148c-a7f1439909da15a6",
        "1e0621f818c44de5700ccb243fb9e8d0a65acdc70943",
        "fbe53e25acb1caf0",
        "d8e13cd700325825",
        "6da37b293519ca78",
        "a045e3c666ffec05-e7e392c0c09c8a99-3a883c8f2a40f915-a9e50659e0e16f08",
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert (
        encoded
        == "pay_s_v6Iiyr9h~HrTDRkZxZ3curnGXjHqSkAawPgXB9UynD5yW68wxpP4VCt0Rb93~XYd2DnJV72kfZXjWCIb7a-dAyfdt0cCxCsrdZajkqQEzxhvf6qM_J1vwABJ30E8HqeFx-AQG0~hnGXgqqWe5M2avMAHTp"
    )
    decoded = NyzoStringEncoder.decode(encoded)
    # todo: More detailed tests (but comparing core bytes storage should be enough)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


if __name__ == "__main__":
    test_vector0()
