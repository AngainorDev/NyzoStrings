import sys

sys.path.append("../")
from nyzostrings.nyzostringprefilleddata import NyzoStringPrefilledData
from nyzostrings.nyzostringencoder import NyzoStringEncoder


def test_vector0():
    nyzo_string = NyzoStringPrefilledData.from_hex(
        "1a74dff9c1bb47f7-01eabcfd217f2d6e-ab58a6889efaa44b-5bbe06d396596560",
        "82fb2a31c2fdedd9",
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert (
        encoded
        == "pre_ahGSV_E1LSwV0vH-_i5_bnYInar8EMHBiTL~1Kennnmx28bZaA72_vVqroRgFqRe"
    )
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.receiver_identifier == nyzo_string.receiver_identifier
    assert decoded.sender_data == nyzo_string.sender_data
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector17000():
    nyzo_string = NyzoStringPrefilledData.from_hex(
        "53daaf0f7243222a-89324a82a2f2da6d-e9a3c025c3156b9d-fbd1bdab6af1409c",
        "536142cd5127b085fd48d3512cc3300abdd7bbca774d691e76437f7db0",
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert (
        encoded
        == "pre_fCfrIN.QgQ8Hzj9axHbQUDVGF-0CNPmIEwMhMrKH-k2t7mdygJTh9Z25_kAjkiR3c0H.TZMauSTG7Eq3wVUNIh0cVwG-"
    )
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.receiver_identifier == nyzo_string.receiver_identifier
    assert decoded.sender_data == nyzo_string.sender_data
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector44000():
    nyzo_string = NyzoStringPrefilledData.from_hex(
        "b0c5aef7f03d6c95-e6643f98e12196cb-41fff5e71d4903f4-55419cf80e28781e", ""
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "pre_8s35IMwNfnQmXDg_De4yCJK1__oE7kB3.5m1Efxea7xv0c64GT24"
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.receiver_identifier == nyzo_string.receiver_identifier
    assert decoded.sender_data == nyzo_string.sender_data
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector75000():
    nyzo_string = NyzoStringPrefilledData.from_hex(
        "7182d875367fbb32-eef8831d47079a78-fd5daf7aabaa145e-1bdb4914676ae579",
        "8044e813bd9acf83149a31d819e22c820edc76f3cd00cd87e67958495e562cd3",
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert (
        encoded
        == "pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn"
    )
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.receiver_identifier == nyzo_string.receiver_identifier
    assert decoded.sender_data == nyzo_string.sender_data
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector75000_plus():
    # max data size + more data
    nyzo_string = NyzoStringPrefilledData.from_hex(
        "7182d875367fbb32-eef8831d47079a78-fd5daf7aabaa145e-1bdb4914676ae579",
        "8044e813bd9acf83149a31d819e22c820edc76f3cd00cd87e67958495e562cd38044e813bd9acf83149a31d819e22c820edc76f3cd00cd87e67958495e562cd3",
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert (
        encoded
        == "pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn"
    )
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.receiver_identifier == nyzo_string.receiver_identifier
    assert decoded.sender_data == nyzo_string.sender_data
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector75000_noise18():
    # Add content at end
    encoded = (
        "pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn"
        + "qXn4CvmzRjFuo.qVfn"
    )
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded is None


def test_vector75000_noise1():
    # Add content at end
    encoded = (
        "pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn"
        + "q"
    )
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded is None


def test_vector75000_corrupted():
    # Add content at end
    encoded = "pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn3CvmzRjFuo.qVfn"  # 1 changed char
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded is None


if __name__ == "__main__":
    test_vector0()
