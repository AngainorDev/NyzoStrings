# Reference implementation tests vector extraction

For reference, here are the code snippets that were used to log the test vectors from this repo

src/main/java/co/nyzo/verifier/tests/NyzoStringTest.java

testPublicIdentifierStrings  
`̀`
            if (i % 1000 == 0) {
                System.out.println(i);
                System.out.println(ByteUtil.arrayAsStringWithDashes(seed));
                System.out.println(encoded);
            }
`̀`
            
testPublicIdentifierStrings  
`̀`
            if (i % 1000 == 0) {
                System.out.println(i);
                System.out.println(ByteUtil.arrayAsStringWithDashes(identifier));
                System.out.println(encoded);
            }
`̀`

testNyzoMicropayStrings  
`̀`
	if (i % 1000 == 0) {
                System.out.println(i);
                System.out.println(ByteUtil.arrayAsStringWithDashes(receiverIdentifier));
                System.out.println(ByteUtil.arrayAsStringNoDashes(senderData));
                System.out.printf("|%x| %d%n",amount,amount);
                System.out.printf("|%x| %d%n",timestamp,timestamp);
                System.out.printf("|%x| %d%n",previousHashHeight,previousHashHeight);
                System.out.println(ByteUtil.arrayAsStringWithDashes(previousBlockHash));
                System.out.println(encoded);
            }
`̀`

testPrefilledDataStrings  
`̀`
	if (i % 1000 == 0) {
                System.out.println(i);
                System.out.println(ByteUtil.arrayAsStringWithDashes(receiverIdentifier));
                System.out.println(ByteUtil.arrayAsStringNoDashes(senderData));
                System.out.println(encoded);
            }
`̀`

testTransactionStrings  
`̀`
	if (i % 1000 == 0) {
                System.out.println(i);
                System.out.printf("|%x| %d%n",timestamp,timestamp);
                System.out.printf("|%x| %d%n",amount,amount);
                System.out.println(ByteUtil.arrayAsStringWithDashes(receiverIdentifier));
                System.out.printf("|%x| %d%n",previousHashHeight,previousHashHeight);
                System.out.println(ByteUtil.arrayAsStringWithDashes(previousBlockHash));
                System.out.println(ByteUtil.arrayAsStringWithDashes(senderIdentifier));
                System.out.println(ByteUtil.arrayAsStringNoDashes(senderData));
                System.out.println(ByteUtil.arrayAsStringNoDashes(signature));
                System.out.println(encoded);
            }
`̀`
