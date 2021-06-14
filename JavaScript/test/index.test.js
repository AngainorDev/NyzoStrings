const { NyzoTypes, NyzoStringType } = require('../src/NyzoStringType')
const { NyzoString } = require('../src/NyzoString')
const { NyzoStringPublicIdentifier } = require('../src/NyzoStringPublicIdentifier')
const { NyzoStringPrivateSeed } = require('../src/NyzoStringPrivateSeed')
const { NyzoStringPrefilledData } = require('../src/NyzoStringPrefilledData')
const { NyzoStringMicropay } = require('../src/NyzoStringMicropay')
const { NyzoStringTransaction } = require('../src/NyzoStringTransaction')
const { NyzoStringSignature } = require('../src/NyzoStringSignature')
const { nyzoStringEncoder } = require('../src/NyzoStringEncoder')

const Int64 = require('node-int64')

/*
describe("Tests Debug", () => {
  test("Trace1", () => {
    const ttyped = NyzoStringType.forType('PrefilledData')
    console.log("Type PrefilledData", ttyped)
    const ttype = NyzoStringType.forType('PublicIdentifier')
    console.log("Type PublicIdentifier", ttype)
    const ttype2 = NyzoStringType.forType('PrivateSeed')
    console.log("Type PrivateSeed", ttype2)
    const ttype3 = NyzoStringType.forType('Micropay')
    console.log("Type Micropay", ttype3)
    const ttype4 = NyzoStringType.forType('Transaction')
    console.log("Type Transaction", ttype4)
    const ttype5 = NyzoStringType.forType('Signature')
    console.log("Type Transaction", ttype5)
  })
 })
*/

describe("Old charset Tests", () => {
      test("TODO", () => {

      })
})


describe("PublicIdentifier Tests", () => {
  test("Vector 0", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("848db2de31cbe4c4-28dbb9e6bdda3aba-98581356ab0e6e02-37b37fd370ac3c7b")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__88idJKWPQ~j4adLXXIVreIHpn1dnHNXL0AvRw.dNI3PZXtxdHx7u')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 8000", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("1a7d496278a9ffc7-febfed9f3e8d83ab-eb4a227d020fbbaa-ab1544f0cef8f53f")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__81G.in9WHw_7_I_KERYdxYMIiz9.0x~ZHHJmhf3e~fk_3tn4IuEs')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 13000", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("39558c7380ba4817-1a748b48fac7bed0-b2d5cbff5d38bf45-8b1f41aacef67881")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__83CmA7e0LBxo6EibifI7MK2QTtM_ojz_hpJwgrIe.Ez1H8dsIm5.')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 19000", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("4c66c2c9ef2f6d7a-ec0057d224dcf8eb-f21ce9f1f938fd7c-b3ab6c77ffd805cc")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__84PDNJEMbUTYZ01oSzjt~eMQ7eEP~jA.wbeIs7w_U0ocYX2G.tGZ')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 25000", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("701a37089b596a18-b719922a543fff1b-54879e7ca1d4fd5c-64eabd2c85d55231")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__870rdNzsnnFpKPDiaCg__PKkyXX-Fuj.o6jHMiQ5Tm8PkBAY.aa9')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 79000", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("af4fdb9a637d7e83-a0b9d222e3cd1326-8c07c20ad66cf08e-b506f79d2865e2ad")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__8a.fUXGAwoY3FbEi8Lfd4Qrc1-8aTDRNAIk6.XSFqvaKuiPwfgjC')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
 })


describe("PrivateSeed Tests", () => {
  test("Vector 0", () => {
    const nyzoString = NyzoStringPrivateSeed.fromHex("74d84ed425f51e6f-aa9bae140e952601-29d16a73241231dc-6962619b5fbc6e27")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('key_87jpjKgC.hXMHGLL50Ym9x4GSnGR918PV6CzpqKwM6WEgqRzfABZ')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 8000", () => {
    const nyzoString = NyzoStringPrivateSeed.fromHex("83a2c34eef86da60-e0d26b82a305367b-cf4ed6893ed5d807-0f2fae99a97d77bd")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('key_88ezNSZMyKGxWd9IxHc5dEMfjKr9fKop1N-MIGDGwov.tBBqPRDY')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 13000", () => {
    const nyzoString = NyzoStringPrivateSeed.fromHex("e58d51a913e209db-8645d6d78f061309-d2af2ef1ed651788-4ea8d4bc4f678401")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('key_8endkrBjWxEsyBonTW-64NEiIQZPZnkoz4YFTbPfqWg1jt28sUiM')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 19000", () => {
    const nyzoString = NyzoStringPrivateSeed.fromHex("c253802154f4aa04-906275b8f922ed86-81cf11d2cac11a92-8dcdf3bee1c5af32")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('key_8c9jx25k.aF4B69TLfBzZpr1RP7iQJ4rBFVd-ZZyPr-QQWm3Ivcv')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 25000", () => {
    const nyzoString = NyzoStringPrivateSeed.fromHex("2882cc9feb9e0861-ccb999c8400cf515-49b73fab4cc6c7a8-0cffef201fc2e777")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('key_82z2R9_IExyyRbDqQ40c.hm9KR~Ijcs7H0R_ZQ0wNLuV9ieWk_p4')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 79000", () => {
    const nyzoString = NyzoStringPrivateSeed.fromHex("d60987f22773e4c7-7efb079e9900554e-b6efb568de81ec74-f7396efab7f5605d")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('key_8dp9y_8Et~j7wMJ7EGB0mkYUZZmFVF7JuftXsMHV.n1upfKfwunh')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
 })


 describe("Prefilled Data Tests", () => {
  test("Vector 0", () => {
    const nyzoString = NyzoStringPrefilledData.fromHex("1a74dff9c1bb47f7-01eabcfd217f2d6e-ab58a6889efaa44b-5bbe06d396596560", "82fb2a31c2fdedd9")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('pre_ahGSV_E1LSwV0vH-_i5_bnYInar8EMHBiTL~1Kennnmx28bZaA72_vVqroRgFqRe')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getReceiverIdentifier()).toEqual(nyzoString.getReceiverIdentifier())
    expect(decoded.getSenderData()).toEqual(nyzoString.getSenderData())
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
    expect(decoded.getAmount().toString()).toEqual("0")
  })
  test("Vector 17000", () => {
    const nyzoString = NyzoStringPrefilledData.fromHex("53daaf0f7243222a-89324a82a2f2da6d-e9a3c025c3156b9d-fbd1bdab6af1409c", "536142cd5127b085fd48d3512cc3300abdd7bbca774d691e76437f7db0")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('pre_fCfrIN.QgQ8Hzj9axHbQUDVGF-0CNPmIEwMhMrKH-k2t7mdygJTh9Z25_kAjkiR3c0H.TZMauSTG7Eq3wVUNIh0cVwG-')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getReceiverIdentifier()).toEqual(nyzoString.getReceiverIdentifier())
    expect(decoded.getSenderData()).toEqual(nyzoString.getSenderData())
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
    expect(decoded.getAmount().toString()).toEqual("0")
  })
  test("Vector 44000", () => {
    // Take care to include at least one test with empty data
    const nyzoString = NyzoStringPrefilledData.fromHex("b0c5aef7f03d6c95-e6643f98e12196cb-41fff5e71d4903f4-55419cf80e28781e", "")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('pre_8s35IMwNfnQmXDg_De4yCJK1__oE7kB3.5m1Efxea7xv0c64GT24')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getReceiverIdentifier()).toEqual(nyzoString.getReceiverIdentifier())
    expect(decoded.getSenderData()).toEqual(nyzoString.getSenderData())
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
    expect(decoded.getAmount().toString()).toEqual("0")
  })
  test("Vector 75000", () => {
    // max data size
    const nyzoString = NyzoStringPrefilledData.fromHex("7182d875367fbb32-eef8831d47079a78-fd5daf7aabaa145e-1bdb4914676ae579", "8044e813bd9acf83149a31d819e22c820edc76f3cd00cd87e67958495e562cd3")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getReceiverIdentifier()).toEqual(nyzoString.getReceiverIdentifier())
    expect(decoded.getSenderData()).toEqual(nyzoString.getSenderData())
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
    expect(decoded.getAmount().toString()).toEqual("0")
  })
})


 describe("Prefilled Data Custom Tests", () => {
    // include custom tests with too large a data buffer
  test("Vector 75000+", () => {
    // max data size + more data
    const nyzoString = NyzoStringPrefilledData.fromHex("7182d875367fbb32-eef8831d47079a78-fd5daf7aabaa145e-1bdb4914676ae579", "8044e813bd9acf83149a31d819e22c820edc76f3cd00cd87e67958495e562cd38044e813bd9acf83149a31d819e22c820edc76f3cd00cd87e67958495e562cd3")

    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getReceiverIdentifier()).toEqual(nyzoString.getReceiverIdentifier())
    expect(decoded.getSenderData()).toEqual(nyzoString.getSenderData())
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
    expect(decoded.getAmount().toString()).toEqual("0")
  })
  test("Vector 75000 + noise18", () => {
    const encoded2 = 'pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn' + 'qXn4CvmzRjFuo.qVfn' // Add content at end
    const decoded2 = nyzoStringEncoder.decode(encoded2)
    expect(decoded2).toBe(null)  // checksum len does not match 4 to 6
  })
  test("Vector 75000 + noise1", () => {
    const encoded2 = 'pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn4CvmzRjFuo.qVfn' + 'q' // Add content at end
    const decoded2 = nyzoStringEncoder.decode(encoded2)
    expect(decoded2).toBe(null)  // checksum len does not match 4 to 6
  })
  test("Vector 75000 corrupted", () => {
    const encoded2 = 'pre_go62U7kUwZJQZMz37kt7DEA.or.YHYFkoyMsihhErLmX8814Y1e.DJ~359FPU1Ezb88eV7sRRg3dy~qXn3CvmzRjFuo.qVfn' // 1 changed char
    const decoded2 = nyzoStringEncoder.decode(encoded2)
    expect(decoded2).toBe(null)  // checksum does not match
  })

 })


describe("Prefilled Data Custom Tests 2", () => {
    // include custom tests from the python port, with extra amount
  test("Vector prefilled with amount", () => {
    // max data size + more data
    const nyzoString = NyzoStringPrefilledData.fromHex("848db2de31cbe4c4-28dbb9e6bdda3aba-98581356ab0e6e02-37b37fd370ac3c7b", "", new Int64(10*1000000))
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('pre_apidJKWPQ~j4adLXXIVreIHpn1dnHNXL0AvRw.dNI3PZx0000000D9r0fJmDjEFZ')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getReceiverIdentifier()).toEqual(nyzoString.getReceiverIdentifier())
    expect(decoded.getSenderData()).toEqual(nyzoString.getSenderData())
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
    expect(decoded.getAmount().toString()).toEqual("10000000")
  })
 })


describe("Micropay Tests", () => {
  test("Vector 0", () => {
    const nyzoString = NyzoStringMicropay.fromHex("f786ad285a251faa-6b59b353b83b0cc7-5a5a9e53a99d148c-a7f1439909da15a6",
        "1e0621f818c44de5700ccb243fb9e8d0a65acdc70943",
        "fbe53e25acb1caf0", "d8e13cd700325825", "6da37b293519ca78",
        "a045e3c666ffec05-e7e392c0c09c8a99-3a883c8f2a40f915-a9e50659e0e16f08"
        )
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('pay_s_v6Iiyr9h~HrTDRkZxZ3curnGXjHqSkAawPgXB9UynD5yW68wxpP4VCt0Rb93~XYd2DnJV72kfZXjWCIb7a-dAyfdt0cCxCsrdZajkqQEzxhvf6qM_J1vwABJ30E8HqeFx-AQG0~hnGXgqqWe5M2avMAHTp')
    const decoded = nyzoStringEncoder.decode(encoded)
    // todo: More detailed tests (but comparing core bytes storage should be enough)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })

})



describe("Transaction Tests", () => {
  test("Vector 0", () => {
    const nyzoString = NyzoStringTransaction.fromHex("9bdecd1085b8f5e1", "545d4b257f8def80",
        "3ce4eaf311934276-673752ccb5cf4cac-61eed231d8fcb649-6310887ecf99f6e5", "e6e882dc8cd92291",
        "d5fbaeaeb085b299-eb028094fe472330-5eb9f6427e7c3d38-7ece7edc91fb3983",
        "7695f21b83c22fff-5172d720e6aca180-a017d5af55dbd85f-3b23526794a75872",
        "360cb35fc71a111e2576cf",
        "6a675732bd20a2c203a925fc62f1d5249b98c128b555472c980f84d9d37fb3452c7211ea448eeed51b7af17785490593a429e97a4f373788a1a768e40d64657c"
        )
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('tx__GgasVJSgysATWmhuiQm_Av~0fejH-P6jgEqEdTbcKt.cI67LSA7p_bq9pP28wJ~q.LoDY8btAdBzBorm-yL3Nz__kobo8erJFp2x5.nMmuMpoRJAkDvkGTyQ2RpcJT_76y4v9osfrDuocISxFJ83Hio-pM7m99LpNizTmktJD0~4Uud_JSkJty7Hh8ZLThKY-ov5ignjG2EGvB-VdWzyGUAB3nhCwe~GDN_e')
    const decoded = nyzoStringEncoder.decode(encoded)
    // todo: More detailed tests (but comparing core bytes storage should be enough)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 26000", () => {
    const nyzoString = NyzoStringTransaction.fromHex("ba94f30cfffa6590", "ba80822eefb07338",
        "7aad5eb4000f5400-a848d584c7eeabd9-4e28ed04a249115f-a17c126bf9fe896c", "7091c9f882e5b51d",
        "d8f53af77b321d7b-82f04ff1db0c86fa-6516744752fcd9e0-df49f5a7c83bd148",
        "2e4df5134377f512-86ddee2159689033-a0cb484d757b223f-439b6c7cd03c5d2f",
        "",
        "54ea57754c832e04bdef6d06adbab4a7b754550b92bb7323c7d0fa75825bd8d2445f49bc5926359eac5de99e9b36b30113894f3f0a4e5afd8523a5763ea90483"
        )
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('tx__DxaYCfcc__GCBbH0xzZMJ7cWvHTvK00fm02Fidn4P~YIUkWFZgizih5wFoNir_E~znPNBtEWxLnT7iXd.hd3u_kiyKVL8mCFB3exQSyduoJzfSess7Rgf5SM05jHmVmcxQW4Mv.K1HUYKavVm5kbBIKR8-wg~En2n.Aih5.9M5BDdqYJovDvDRrR0he9jR-ajCI.yieCuAYG18cYfyrZ')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })

})


describe("Signature Tests", () => {
  test("Decode 0", () => {
    const encoded = "sig_g2kGPq81_97Rj-T3ampXC_H9Y~5I5okrKIBY2qzcsndZDzAiGV~xaA6kqMIi.tNIrxf3N6vkPBYPDQgS8WcJ_x6Ya_pG"
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes().toString('hex')).toEqual("2529c59201fc91f34fcd4329563997fa89ebe16b15751ab6b93a09988c6d637b9a28d2a77fa02a319466fad2f5cc2b6a03c3c06794c64eb19b243423832cfe01")
  })
  test("Vector 0", () => {
    const nyzoString = new NyzoStringSignature(Buffer.from("2529c59201fc91f34fcd4329563997fa89ebe16b15751ab6b93a09988c6d637b9a28d2a77fa02a319466fad2f5cc2b6a03c3c06794c64eb19b243423832cfe01",'hex'))
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toEqual("sig_g2kGPq81_97Rj-T3ampXC_H9Y~5I5okrKIBY2qzcsndZDzAiGV~xaA6kqMIi.tNIrxf3N6vkPBYPDQgS8WcJ_x6Ya_pG")
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
  test("Vector 1", () => {
    const nyzoString = new NyzoStringSignature(Buffer.from("1da1460c6b796f7e44734fd2a7b01c63846e42df4ba422a717c1e1389b5a0e539f2337c41345d86b12a9b48728eb72483f85a2d8fde0b612bdcd85453b05b702",'hex'))
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toEqual("sig_g1UyhxPIvn.~h7dfSHvN76e4sBbwiYgzGPw1WjzsnxXjEQcVP1d5U6JiHsi7aeKQi3~5FKA.WbpiMtU5hjJ5KN8xEaQt")
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
})


describe("Vote Transaction Tests", () => {
 // This is no official test vector, with fake info. Do not use as a real test vector until confirmed.
 test("Vector 0", () => {
    // timestampHex, senderHex, signatureHex, vote, transactionSignatureHex {
    const nyzoString = NyzoStringTransaction.fromHexVote(
        "9bdecd1085b8f5e1",
        "3ce4eaf311934276-673752ccb5cf4cac-61eed231d8fcb649-6310887ecf99f6e5",
        "6a675732bd20a2c203a925fc62f1d5249b98c128b555472c980f84d9d37fb3452c7211ea448eeed51b7af17785490593a429e97a4f373788a1a768e40d64657c",
        1,
        "1da1460c6b796f7e44734fd2a7b01c63846e42df4ba422a717c1e1389b5a0e539f2337c41345d86b12a9b48728eb72483f85a2d8fde0b612bdcd85453b05b702" // fake sig
        )
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('tx__HxisVJSgysATWjRBYMchBS9UqRuiRbofjaPyZK8PUfQUincgz7ZfDwsC0hUyhxPIvn.~h7dfSHvN76e4sBbwiYgzGPw1WjzsnxXjEQcVP1d5U6JiHsi7aeKQi3~5FKA.WbpiMtU5hjJ5KN9HqTtQMi2zNxeG9wPz-ukBDXA1abmmhQQp3WjqSV~RhiPQ4vG4ALZm6VIPuWm91qeBavCYjRtVza6Eregdq6m-hccQ7-vf')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })
})
