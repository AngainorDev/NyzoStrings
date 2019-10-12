const { NyzoTypes, NyzoStringType } = require('../src/NyzoStringType')
const { NyzoString } = require('../src/NyzoString')
const { NyzoStringPublicIdentifier } = require('../src/NyzoStringPublicIdentifier')
const { NyzoStringPrivateSeed } = require('../src/NyzoStringPrivateSeed')

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

