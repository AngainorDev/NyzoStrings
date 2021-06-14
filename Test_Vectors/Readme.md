# Test Vectors

## Goal

Provide test vectors issued by the reference Java Implementation, so other implementations in other languages can match against.

## Method

Test script from official code has been modified to print every 1000th tested value, thus providing several test vectors for every nyzoString type.

## Files

All extracted test vectors are text files.  
Parameters are listed - one per line - in the same order as the NyzoString construtor parameters.

**Vectors_PrivateSeed.txt**
  
3 lines per test:
  
- Test#
- Seed in hex-with-dashes format
- Matching NyzoString

**Vectors_PublicIdentifier.txt**
  
3 lines per test:
  
- Test#
- Identifier in hex-with-dashes format
- Matching NyzoString

**Vectors_Micropay.txt**

8 lines per test:

- Test#
- receiverIdentifier in hex-with-dashes format
- senderData as hex string (can be null)
- amount |as hex| and as long
- timestamp |as hex| and as long
- previousHashHeight |as hex| and as long
- previousBlockHash in hex-with-dashes format
- Matching NyzoString

**Vectors_PrefilledData.txt**

4 lines per test:
  
- Test#
- receiverIdentifier in hex-with-dashes format
- senderData in hex format (can be null)
- Matching NyzoString

**Vectors_Transaction.txt**

10 lines per test:

- Test#
- timestamp |as hex| and as long
- amount |as hex| and as long
- receiverIdentifier in hex-with-dashes format
- previousHashHeight |as hex| and as long
- previousBlockHash in hex-with-dashes format
- senderIdentifier in hex-with-dashes format
- senderData as hex string (can be null)
- signature as hex string
- Matching NyzoString
