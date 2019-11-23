import sys

sys.path.append("../")
from nyzostrings.nyzostringpublicidentifier import NyzoStringPublicIdentifier
from nyzostrings.nyzostringencoder import NyzoStringEncoder


def test_vector0():
    nyzo_string = NyzoStringPublicIdentifier.from_hex(
        "848db2de31cbe4c4-28dbb9e6bdda3aba-98581356ab0e6e02-37b37fd370ac3c7b"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "id__88idJKWPQ~j4adLXXIVreIHpn1dnHNXL0AvRw.dNI3PZXtxdHx7u"
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector8000():
    nyzo_string = NyzoStringPublicIdentifier.from_hex(
        "1a7d496278a9ffc7-febfed9f3e8d83ab-eb4a227d020fbbaa-ab1544f0cef8f53f"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "id__81G.in9WHw_7_I_KERYdxYMIiz9.0x~ZHHJmhf3e~fk_3tn4IuEs"
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector13000():
    nyzo_string = NyzoStringPublicIdentifier.from_hex(
        "39558c7380ba4817-1a748b48fac7bed0-b2d5cbff5d38bf45-8b1f41aacef67881"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "id__83CmA7e0LBxo6EibifI7MK2QTtM_ojz_hpJwgrIe.Ez1H8dsIm5."
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector19000():
    nyzo_string = NyzoStringPublicIdentifier.from_hex(
        "4c66c2c9ef2f6d7a-ec0057d224dcf8eb-f21ce9f1f938fd7c-b3ab6c77ffd805cc"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "id__84PDNJEMbUTYZ01oSzjt~eMQ7eEP~jA.wbeIs7w_U0ocYX2G.tGZ"
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector25000():
    nyzo_string = NyzoStringPublicIdentifier.from_hex(
        "701a37089b596a18-b719922a543fff1b-54879e7ca1d4fd5c-64eabd2c85d55231"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "id__870rdNzsnnFpKPDiaCg__PKkyXX-Fuj.o6jHMiQ5Tm8PkBAY.aa9"
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector79000():
    nyzo_string = NyzoStringPublicIdentifier.from_hex(
        "af4fdb9a637d7e83-a0b9d222e3cd1326-8c07c20ad66cf08e-b506f79d2865e2ad"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "id__8a.fUXGAwoY3FbEi8Lfd4Qrc1-8aTDRNAIk6.XSFqvaKuiPwfgjC"
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


if __name__ == "__main__":
    test_vector0()
