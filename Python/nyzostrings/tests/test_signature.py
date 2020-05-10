import sys

sys.path.append("../")
from nyzostrings.nyzostringsignature import NyzoStringSignature
from nyzostrings.nyzostringencoder import NyzoStringEncoder


def test_decode0():
    encoded = "sig_g2kGPq81_97Rj-T3ampXC_H9Y~5I5okrKIBY2qzcsndZDzAiGV~xaA6kqMIi.tNIrxf3N6vkPBYPDQgS8WcJ_x6Ya_pG"
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.get_bytes().hex() == "2529c59201fc91f34fcd4329563997fa89ebe16b15751ab6b93a09988c6d637b9a28d2a77fa02a319466fad2f5cc2b6a03c3c06794c64eb19b243423832cfe01"


def test_vector0():
    nyzo_string = NyzoStringSignature.from_hex(
        "2529c59201fc91f34fcd4329563997fa89ebe16b15751ab6b93a09988c6d637b9a28d2a77fa02a319466fad2f5cc2b6a03c3c06794c64eb19b243423832cfe01"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    # oops10
    assert encoded == "sig_g2kGPq81_97Rj-T3ampXC_H9Y~5I5okrKIBY2qzcsndZDzAiGV~xaA6kqMIi.tNIrxf3N6vkPBYPDQgS8WcJ_x6Ya_pG"
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector1():
    nyzo_string = NyzoStringSignature.from_hex(
        "1da1460c6b796f7e44734fd2a7b01c63846e42df4ba422a717c1e1389b5a0e539f2337c41345d86b12a9b48728eb72483f85a2d8fde0b612bdcd85453b05b702"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    # lucyLuky17
    assert encoded == "sig_g1UyhxPIvn.~h7dfSHvN76e4sBbwiYgzGPw1WjzsnxXjEQcVP1d5U6JiHsi7aeKQi3~5FKA.WbpiMtU5hjJ5KN8xEaQt"
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


if __name__ == "__main__":
    test_decode0()
    test_vector0()
