function calculateSmsParts(message) {
    const GSM_7BIT_SINGLE_LIMIT = 160;
    const GSM_7BIT_MULTIPART_LIMIT = 153;
    const UCS2_SINGLE_LIMIT = 70;
    const UCS2_MULTIPART_LIMIT = 67;
    function isGsm7Bit(text) {
      // List of GSM 7-bit characters
      const gsm7BitChars = '@Â£$Â¥Ã¨Ã©Ã¹Ã¬Ã²Ã‡\nÃ˜Ã¸\rÃ…Ã¥Î”_Î¦Î“Î›Î©Î Î¨Î£Î˜Îž\x1BÃ†Ã¦ÃŸÃ‰ !"#Â¤%&\'()*+,-./0123456789:;<=>?Â¡ABCDEFGHIJKLMNOPQRSTUVWXYZÃ„Ã–Ã‘ÃœÂ§Â¿abcdefghijklmnopqrstuvwxyzÃ¤Ã¶Ã±Ã¼Ã ';
      for (let i = 0; i < text.length; i++) {
        if (!gsm7BitChars.includes(text[i])) {
          return false;
        }
      }
      return true;
    }
  
    const isGsm7 = isGsm7Bit(message);
    const singleLimit = isGsm7 ? GSM_7BIT_SINGLE_LIMIT : UCS2_SINGLE_LIMIT;
    const multipartLimit = isGsm7 ? GSM_7BIT_MULTIPART_LIMIT : UCS2_MULTIPART_LIMIT;
  
    const messageLength = message.length;
  
    if (messageLength <= singleLimit) {
      return 1; // Fits in a single SMS
    } else {
      // Calculate the number of parts for multi-part SMS
      return Math.ceil(messageLength / multipartLimit);
    }
  }