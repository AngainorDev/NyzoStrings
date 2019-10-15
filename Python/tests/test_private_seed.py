import sys

sys.path.append("../")
from nyzostrings.nyzostringprivateseed import NyzoStringPrivateSeed
from nyzostrings.nyzostringencoder import NyzoStringEncoder


def test_vector0():
    nyzo_string = NyzoStringPrivateSeed.from_hex(
        "74d84ed425f51e6f-aa9bae140e952601-29d16a73241231dc-6962619b5fbc6e27"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "key_87jpjKgC.hXMHGLL50Ym9x4GSnGR918PV6CzpqKwM6WEgqRzfABZ"


def test_vector8000():
    nyzo_string = NyzoStringPrivateSeed.from_hex(
        "83a2c34eef86da60-e0d26b82a305367b-cf4ed6893ed5d807-0f2fae99a97d77bd"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "key_88ezNSZMyKGxWd9IxHc5dEMfjKr9fKop1N-MIGDGwov.tBBqPRDY"


def test_vector13000():
    nyzo_string = NyzoStringPrivateSeed.from_hex(
        "e58d51a913e209db-8645d6d78f061309-d2af2ef1ed651788-4ea8d4bc4f678401"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "key_8endkrBjWxEsyBonTW-64NEiIQZPZnkoz4YFTbPfqWg1jt28sUiM"


def test_vector19000():
    nyzo_string = NyzoStringPrivateSeed.from_hex(
        "c253802154f4aa04-906275b8f922ed86-81cf11d2cac11a92-8dcdf3bee1c5af32"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "key_8c9jx25k.aF4B69TLfBzZpr1RP7iQJ4rBFVd-ZZyPr-QQWm3Ivcv"


def test_vector25000():
    nyzo_string = NyzoStringPrivateSeed.from_hex(
        "2882cc9feb9e0861-ccb999c8400cf515-49b73fab4cc6c7a8-0cffef201fc2e777"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "key_82z2R9_IExyyRbDqQ40c.hm9KR~Ijcs7H0R_ZQ0wNLuV9ieWk_p4"


def test_vector79000():
    nyzo_string = NyzoStringPrivateSeed.from_hex(
        "d60987f22773e4c7-7efb079e9900554e-b6efb568de81ec74-f7396efab7f5605d"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert encoded == "key_8dp9y_8Et~j7wMJ7EGB0mkYUZZmFVF7JuftXsMHV.n1upfKfwunh"


if __name__ == "__main__":
    test_vector0()
