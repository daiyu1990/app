
export default {
  isEmail(value) {
    var r = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/ //邮箱
    return r.test(value);
  },
  isPositiveInteger(value) {
    var r = /^[0-9]*[1-9][0-9]*$/　　//正整数 
    return r.test(value); 
  },
  isInteger(value) {
    var r = /^[0-9]*$/　　//整数
    return r.test(value); 
  },
  isIntegerNz(value) {
    var r = /^\+?[1-9][0-9]*$/　　//非零正整数
    return r.test(value);
  },
  isBankcardNumber(bankcard) {
    if (bankcard.length < 15 || bankcard.length > 20) {
      return false;
    }
    return /^[0-9]+$/.test(bankcard);
  },

  isMobile(mobile) {
    return /^1[3|4|5|7|8][0-9]{9}$/.test(mobile);
  },

  isVerifyCode(code) {
    return /^[0-9]{6}$/.test(code);
  },

  isTradePassword(pw) {
    return /^[0-9]{6}$/.test(pw);
  },

  isPassword(pw) {
    return pw && pw.length >= 6 && pw.length <= 20;
  },

  isAmount(value, minAmount, maxAmount) {
    if (isNaN(value) || value < minAmount || value > maxAmount) {
      return false;
    }
    return value % 1 === 0;
  },

  /**
   * ddddddyyyymmddxxsp共18位，其中：
   * yyyy为4位的年份代码，是身份证持有人的出身年份。
   * mm为2位的月份代码，是身份证持有人的出身月份。
   * dd为2位的日期代码，是身份证持有人的出身日。
   * 这8位在一起组成了身份证持有人的出生日期。
   * xx为2位的顺序码，这个是随机数。
   * s为1位的性别代码，奇数代表男性，偶数代表女性。
   * 最后一位为校验位。
   * 校验规则是：
   * （1）十七位数字本体码加权求和公式
   * S = Sum(Ai * Wi), i = 0, ... , 16 ，先对前17位数字的权求和
   * Ai:表示第i位置上的身份证号码数字值
   * Wi:表示第i位置上的加权因子
   * Wi: 7 9 10 5 8 4 2 1 6 3 7 9 10 5 8 4 2
   * （2）计算模
   * Y = mod(S, 11)
   * （3）通过模得到对应的校验码
   * Y: 0 1 2 3 4 5 6 7 8 9 10
   * 校验码: 1 0 X 9 8 7 6 5 4 3 2
   * 也就是说，如果得到余数为1则最后的校验位p应该为对应的0.如果校验位不是，则该身份证号码不正确。
   */
  isIdentityId(iid) {
    if (iid.length !== 18) {
      return false;
    }

    // 6 digits of geo code
    let dddddd = iid.substring(0, 6);
    if (!/[0-9]{6}/.test(dddddd)) {
      return false;
    }

    // b-day parts
    let bday = iid.substring(6, 14);
    if (!/[0-9]{8}/.test(bday)) {
      return false;
    }
    // We don;t want to including the moment.js since it is big, just pass this
    // if (!moment(bday, "YYYYMMDD").isValid()) {
    //   return false;
    // }

    // checksum check
    let verifyWeight = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
    let verifyCode = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
    let p = iid.charAt(17).toUpperCase();
    let sum = 0;
    for (let i = 0; i < 17; i++) {
      sum += (iid.charAt(i) - '0') * verifyWeight[i];
    }
    return p === verifyCode[sum % 11];
  },
};
