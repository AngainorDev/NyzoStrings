const { NyzoTypes, NyzoStringType } = require('../src/NyzoStringType')
const { NyzoString } = require('../src/NyzoString')
const { NyzoStringPublicIdentifier } = require('../src/NyzoStringPublicIdentifier')
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


describe("PublicIdentifier Tests", () => {
  test("Vector 0", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("848db2de31cbe4c4-28dbb9e6bdda3aba-98581356ab0e6e02-37b37fd370ac3c7b")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__88idJKWPQ~j4adLXXIVreIHpn1dnHNXL0AvRw.dNI3PZXtxdHx7u')
  })
  test("Vector 8000", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("1a7d496278a9ffc7-febfed9f3e8d83ab-eb4a227d020fbbaa-ab1544f0cef8f53f")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__81G.in9WHw_7_I_KERYdxYMIiz9.0x~ZHHJmhf3e~fk_3tn4IuEs')
  })
  test("Vector 13000", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("39558c7380ba4817-1a748b48fac7bed0-b2d5cbff5d38bf45-8b1f41aacef67881")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__83CmA7e0LBxo6EibifI7MK2QTtM_ojz_hpJwgrIe.Ez1H8dsIm5.')
  })
  test("Vector 19000", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("4c66c2c9ef2f6d7a-ec0057d224dcf8eb-f21ce9f1f938fd7c-b3ab6c77ffd805cc")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__84PDNJEMbUTYZ01oSzjt~eMQ7eEP~jA.wbeIs7w_U0ocYX2G.tGZ')
  })
  test("Vector 25000", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("701a37089b596a18-b719922a543fff1b-54879e7ca1d4fd5c-64eabd2c85d55231")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__870rdNzsnnFpKPDiaCg__PKkyXX-Fuj.o6jHMiQ5Tm8PkBAY.aa9')
  })
  test("Vector 79000", () => {
    const nyzoString = NyzoStringPublicIdentifier.fromHex("af4fdb9a637d7e83-a0b9d222e3cd1326-8c07c20ad66cf08e-b506f79d2865e2ad")
    const encoded = nyzoStringEncoder.encode(nyzoString)
    expect(encoded).toBe('id__8a.fUXGAwoY3FbEi8Lfd4Qrc1-8aTDRNAIk6.XSFqvaKuiPwfgjC')
  })
  // TODO: re-decode as well
 })
