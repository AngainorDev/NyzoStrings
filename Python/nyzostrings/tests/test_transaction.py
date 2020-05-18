import sys

sys.path.append("../")
from nyzostrings.nyzostringtransaction import NyzoStringTransaction
from nyzostrings.nyzostringencoder import NyzoStringEncoder


def test_vector0():
    nyzo_string = NyzoStringTransaction.from_hex(
        "9bdecd1085b8f5e1", "545d4b257f8def80",
        "3ce4eaf311934276-673752ccb5cf4cac-61eed231d8fcb649-6310887ecf99f6e5", "e6e882dc8cd92291",
        "d5fbaeaeb085b299-eb028094fe472330-5eb9f6427e7c3d38-7ece7edc91fb3983",
        "7695f21b83c22fff-5172d720e6aca180-a017d5af55dbd85f-3b23526794a75872",
        "360cb35fc71a111e2576cf",
        "6a675732bd20a2c203a925fc62f1d5249b98c128b555472c980f84d9d37fb3452c7211ea448eeed51b7af17785490593a429e97a4f373788a1a768e40d64657c"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert (
        encoded
        == "tx__GgasVJSgysATWmhuiQm_Av~0fejH-P6jgEqEdTbcKt.cI67LSA7p_bq9pP28wJ~q.LoDY8btAdBzBorm-yL3Nz__kobo8erJFp2x5.nMmuMpoRJAkDvkGTyQ2RpcJT_76y4v9osfrDuocISxFJ83Hio-pM7m99LpNizTmktJD0~4Uud_JSkJty7Hh8ZLThKY-ov5ignjG2EGvB-VdWzyGUAB3nhCwe~GDN_e"
    )
    decoded = NyzoStringEncoder.decode(encoded)
    # todo: More detailed tests (but comparing core bytes storage should be enough)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector26000():
    nyzo_string = NyzoStringTransaction.from_hex(
        "ba94f30cfffa6590", "ba80822eefb07338",
        "7aad5eb4000f5400-a848d584c7eeabd9-4e28ed04a249115f-a17c126bf9fe896c", "7091c9f882e5b51d",
        "d8f53af77b321d7b-82f04ff1db0c86fa-6516744752fcd9e0-df49f5a7c83bd148",
        "2e4df5134377f512-86ddee2159689033-a0cb484d757b223f-439b6c7cd03c5d2f",
        "",
        "54ea57754c832e04bdef6d06adbab4a7b754550b92bb7323c7d0fa75825bd8d2445f49bc5926359eac5de99e9b36b30113894f3f0a4e5afd8523a5763ea90483"
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert (
        encoded
        == "tx__DxaYCfcc__GCBbH0xzZMJ7cWvHTvK00fm02Fidn4P~YIUkWFZgizih5wFoNir_E~znPNBtEWxLnT7iXd.hd3u_kiyKVL8mCFB3exQSyduoJzfSess7Rgf5SM05jHmVmcxQW4Mv.K1HUYKavVm5kbBIKR8-wg~En2n.Aih5.9M5BDdqYJovDvDRrR0he9jR-ajCI.yieCuAYG18cYfyrZ"
    )
    decoded = NyzoStringEncoder.decode(encoded)
    # todo: More detailed tests (but comparing core bytes storage should be enough)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


def test_vector_vote():
    nyzo_string = NyzoStringTransaction.from_hex_vote(
        "9bdecd1085b8f5e1",
        "3ce4eaf311934276-673752ccb5cf4cac-61eed231d8fcb649-6310887ecf99f6e5",
        "6a675732bd20a2c203a925fc62f1d5249b98c128b555472c980f84d9d37fb3452c7211ea448eeed51b7af17785490593a429e97a4f373788a1a768e40d64657c",
        1,
        "1da1460c6b796f7e44734fd2a7b01c63846e42df4ba422a717c1e1389b5a0e539f2337c41345d86b12a9b48728eb72483f85a2d8fde0b612bdcd85453b05b702" # fake sig
    )
    encoded = NyzoStringEncoder.encode(nyzo_string)
    assert (
        encoded
        == "tx__HxisVJSgysATWjRBYMchBS9UqRuiRbofjaPyZK8PUfQUincgz7ZfDwsC0hUyhxPIvn.~h7dfSHvN76e4sBbwiYgzGPw1WjzsnxXjEQcVP1d5U6JiHsi7aeKQi3~5FKA.WbpiMtU5hjJ5KN9HqTtQMi2zNxeG9wPz-ukBDXA1abmmhQQp3WjqSV~RhiPQ4vG4ALZm6VIPuWm91qeBavCYjRtVza6Eregdq6m-hccQ7-vf"
    )
    decoded = NyzoStringEncoder.decode(encoded)
    assert decoded.get_bytes() == nyzo_string.get_bytes()


if __name__ == "__main__":
    test_vector0()
    test_vector_vote()
