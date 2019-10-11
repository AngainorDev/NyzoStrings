# Test Vectors

## Goal

Provide test vectors issued by the reference Java Implementation, so other implementations in oher languages can match against.

## Method

Test script from official code has been modified to print every 1000th tested value, thus providing several test vectors for every nyzoString type.

## Files

All extracted test vectors are text files.

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

