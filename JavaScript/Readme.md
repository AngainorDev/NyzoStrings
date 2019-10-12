# Javascript NyzoString Implementation

## Install

git clone or `npm install nyzostrings`

## Current state

- Test vectors for all string types were extracted from reference Java implementation
- Crude port of the java code to JavaScript
- Working encoding of PublicIdentifier string type
- Working decoding of PublicIdentifier string type
- Working encoding + decoding of PrivateSeed string type
- Working encoding + decoding of PrefilledData string type
- Test suite

## Changelog

- 0.0.4: PrefilledData encoding and decoding, test vectors.
- 0.0.3: PrivateSeed encoding and decoding, test vectors.
- 0.0.2: PublicVerifier decoding
- 0.0.1: First release, supports encoding of PublicVerifier as NyzoString, test vectors
