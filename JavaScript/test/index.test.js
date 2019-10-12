const { NyzoTypes, NyzoStringType } = require('../src/NyzoStringType')
const { NyzoString } = require('../src/NyzoString')
const { NyzoStringPublicIdentifier } = require('../src/NyzoStringPublicIdentifier')
const { NyzoStringPrivateSeed } = require('../src/NyzoStringPrivateSeed')
const { NyzoStringPrefilledData } = require('../src/NyzoStringPrefilledData')
const { NyzoStringMicropay } = require('../src/NyzoStringMicropay')

const { nyzoStringEncoder } = require('../src/NyzoStringEncoder')


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
  })
 })


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
  })
  test("Vector 17000", () => {
    const nyzoString = NyzoStringPrefilledData.fromHex("53daaf0f7243222a-89324a82a2f2da6d-e9a3c025c3156b9d-fbd1bdab6af1409c", "536142cd5127b085fd48d3512cc3300abdd7bbca774d691e76437f7db0")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('pre_fCfrIN.QgQ8Hzj9axHbQUDVGF-0CNPmIEwMhMrKH-k2t7mdygJTh9Z25_kAjkiR3c0H.TZMauSTG7Eq3wVUNIh0cVwG-')
    const decoded = nyzoStringEncoder.decode(encoded)
    expect(decoded.getReceiverIdentifier()).toEqual(nyzoString.getReceiverIdentifier())
    expect(decoded.getSenderData()).toEqual(nyzoString.getSenderData())
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
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
    // todo: More detailled tests (but comparing core bytes storage should be enough)
    expect(decoded.getBytes()).toEqual(nyzoString.getBytes())
  })

})
