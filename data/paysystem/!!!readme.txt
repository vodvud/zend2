��������� � ������ � ������:
config.txt 		- ���� � ������� ������������
kkb.utils.php 		- ������ � ��������� ���������
pay.php 		- �������� � �������� �������
postlink.php 		- �������� ��������� ��� ������ ������ �� �����
postlinktest.php 	- �������� ��� ������������ ������� ���������
postlinktest1.txt
postlinktest2.txt
postlinktest3.txt	- ���������� � ��������� ��� ������������ ���������
template.xml		- ������ ������� ��� �������� � ����
kkbca.pem		- ��������� �������� ���� ���������������
test_prv.pem		- ��������� �������� ����
test_pub.pem		- ��������� �������� ����
.htaccess		- ���� ���������� ������� ��������� � �����

��� ��������� ����������� ������ ������.

���������� ������ � ����� ���������.

������������� �� ������������� ������� �����������:
1. �������� �� ����� �������� ��������� ����� ��� ���������� ������ �������� "PAYSYS"

2. ���������� ����� ������� ��� *NiX �������� ��� CHMOD 750,
�� ��� ���������� ��� ������� FAR ������ CTRL+A � ����������
	 R  W  X   R  W  X   R  W  X
	[x][x][x] [x][ ][x] [ ][ ][ ]

3. ���������� � ����� "PAYSYS" �����:
.htaccess
config.txt, 
kkb.utils.php,
template.xml,
� ��� ���� PEM ����� ������������.

4. ����� �������� ����� "Paytest"

5. ���������� ����� ������� ��� *NiX �������� ��� CHMOD 755,
�� ��� ���������� ��� ������� FAR ������ CTRL+A � ����������
	 R  W  X   R  W  X   R  W  X
	[x][x][x] [x][ ][x] [x][ ][x]
6. ���������� ���� �����
pay.php
postlink.php
postlinktest.php

7. ����� ������������ � ���� �����:
�������� � �������� "www.mysite.kz/paytest/pay.php"
���� �� ������ �������� ���������� ����������:
 E-mail:  test@test.kz
   �� ������ �������� (-�)
  [��, ������� � ������]
- ������ ��� ��������� � �������
�������� ���������� ��������, � Internet Explorer - 
������ ������ ������� ���� �� ��������, ����� ������� ����� "�������� HTML-����".
� ����������� �������� ����� ��������� �����:
<html>
<head>
<title>Pay</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<body>
<form name="SendOrder" method="post" action="https://epay.kkb.kz/jsp/process/logon.jsp">
   <input type="hidden" name="Signed_Order_B64" value="PGRvY3VtZW50PjxtZXJjaGFudCBjZXJ0X2lkPSIwMEMxODJCMTg5IiBuYW1lPSJUZXN0IHNob3AiPg0KCTxvcmRlciBvcmRlcl9pZD0iMDAwMDAxIiBhbW91bnQ9IjEwIiBjdXJyZW5jeT0iMzk4Ij4NCiAgICAJPGRlcGFydG1lbnQgbWVyY2hhbnRfaWQ9IiIgYW1vdW50PSIxMCIvPg0KCTwvb3JkZXI+DQo8L21lcmNoYW50PjxtZXJjaGFudF9zaWduIHR5cGU9IlJTQSI+eTRTT2ZvK01zNFR5c25ITjNYUVFXeHNLbEk0NFhZVVRZV1RlV0M0WFdvblFrQ2NYQzk2TC8vMXE3UGNpVjNDZ3lDNUdxSEd1akkrTWh5QmhZR090QUE9PTwvbWVyY2hhbnRfc2lnbj48L2RvY3VtZW50Pg==">
   E-mail: <input type="text" name="email" size=50 maxlength=50  value="test@test.kz">
   <p>
   <input type="hidden" name="Language" value="eng"> <!-- ���� ����� ������ rus/eng -->
   <input type="hidden" name="BackLink" value="http://www.bl.test.kz">
   <input type="hidden" name="PostLink" value="http://www.pl.tes.kz/post_link.php">
   �� ������ �������� (-�)<br>
   <input type="submit" name="GotoPay"  value="��, ������� � ������" >&nbsp;
</form>
</body>
</html>

���� ���� ���� �������� ���������� ����������, ������ ������� ��������:
<input type="hidden" name="Signed_Order_B64" value="PGRvY3VtZW50PjxtZXJjaGFudCBjZXJ0X2lkPSIwMEMxODJCMTg5IiBuYW1lPSJUZXN0IHNob3AiPg0KCTxvcmRlciBvcmRlcl9pZD0iMDAwMDAxIiBhbW91bnQ9IjEwIiBjdXJyZW5jeT0iMzk4Ij4NCiAgICAJPGRlcGFydG1lbnQgbWVyY2hhbnRfaWQ9IiIgYW1vdW50PSIxMCIvPg0KCTwvb3JkZXI+DQo8L21lcmNoYW50PjxtZXJjaGFudF9zaWduIHR5cGU9IlJTQSI+eTRTT2ZvK01zNFR5c25ITjNYUVFXeHNLbEk0NFhZVVRZV1RlV0M0WFdvblFrQ2NYQzk2TC8vMXE3UGNpVjNDZ3lDNUdxSEd1akkrTWh5QmhZR090QUE9PTwvbWVyY2hhbnRfc2lnbj48L2RvY3VtZW50Pg==">

8. ����� ����������� ������ �����:
�������� � �������� "www.mysite.kz/paytest/postlinktest.php",��������� �������� � ����� ����� � ������� "SUBMIT".
�������� ���� "postlinktest1.txt" �� ������ ������ � ��������, ����� ���������� ��� ���������� 
� ������� ��� � ���� �����, ����� ������� ������ "Submit".
� ���������� ���������� �������� �� ��������� ����������:

Result DATA: 
Postlink Result: BANK_NAME = Kazkommertsbank JSC
Postlink Result: BANK_SIGN_CERT_ID = 00C18327E8
Postlink Result: BANK_SIGN_CHARDATA = xjJwgeLAyWssZr3/gS7TI/xaajoF3USk0B/ZfLv6SYyY/3H8tDHUiyGcV7zDO5+rINwBoTn7b9BrnO/kvQfebIhHbDlCSogz2cB6Qa2ELKAGqs8aDZDekSJ5dJrgmFT6aTfgFgnZRmadybxTMHGR6cn8ve4m0TpQuaPMQmKpxTI=
Postlink Result: BANK_SIGN_TYPE = SHA/RSA
Postlink Result: CUSTOMER_MAIL = SeFrolov@kkb.kz
Postlink Result: CUSTOMER_NAME = Ucaf Test Maest
Postlink Result: CUSTOMER_PHONE = 
Postlink Result: CUSTOMER_SIGN_TYPE = RSA
Postlink Result: DEPARTMENT_AMOUNT = 1000
Postlink Result: DEPARTMENT_MERCHANT_ID = 92056001
Postlink Result: MERCHANT_CERT_ID = 00C182B189
Postlink Result: MERCHANT_NAME = test merch
Postlink Result: MERCHANT_SIGN_TYPE = RSA
Postlink Result: ORDER_AMOUNT = 1000
Postlink Result: ORDER_CURRENCY = 398
Postlink Result: ORDER_ORDER_ID = 0706172110
Postlink Result: PAYMENT_AMOUNT = 1000
Postlink Result: PAYMENT_APPROVAL_CODE = 447753
Postlink Result: PAYMENT_MERCHANT_ID = 92056001
Postlink Result: PAYMENT_REFERENCE = 618704198173
Postlink Result: PAYMENT_RESPONSE_CODE = 00
Postlink Result: RESULTS_TIMESTAMP = 2006-07-06 17:21:50
Postlink Result: TAG_BANK = BANK
Postlink Result: TAG_BANK_SIGN = BANK_SIGN
Postlink Result: TAG_CUSTOMER = CUSTOMER
Postlink Result: TAG_CUSTOMER_SIGN = CUSTOMER_SIGN
Postlink Result: TAG_DEPARTMENT = DEPARTMENT
Postlink Result: TAG_DOCUMENT = DOCUMENT
Postlink Result: TAG_MERCHANT = MERCHANT
Postlink Result: TAG_MERCHANT_SIGN = MERCHANT_SIGN
Postlink Result: TAG_ORDER = ORDER
Postlink Result: TAG_PAYMENT = PAYMENT
Postlink Result: TAG_RESULTS = RESULTS
Postlink Result: LETTER = 
Postlink Result: SIGN = xjJwgeLAyWssZr3/gS7TI/xaajoF3USk0B/ZfLv6SYyY/3H8tDHUiyGcV7zDO5+rINwBoTn7b9BrnO/kvQfebIhHbDlCSogz2cB6Qa2ELKAGqs8aDZDekSJ5dJrgmFT6aTfgFgnZRmadybxTMHGR6cn8ve4m0TpQuaPMQmKpxTI=
Postlink Result: RAWSIGN = xjJwgeLAyWssZr3/gS7TI/xaajoF3USk0B/ZfLv6SYyY/3H8tDHUiyGcV7zDO5+rINwBoTn7b9BrnO/kvQfebIhHbDlCSogz2cB6Qa2ELKAGqs8aDZDekSJ5dJrgmFT6aTfgFgnZRmadybxTMHGR6cn8ve4m0TpQuaPMQmKpxTI=
Postlink Result: CHECKRESULT = [SIGN_GOOD]

���� CHECKRESULT = [SIGN_GOOD] ������ � ��� ��� �������� ���������.

postlinktest2.txt - ���� ������ ����� � ��������� �������
postlinktest3.txt - ���� ������ ����� � ������� ����������� ������������

9. E��� ��� ����� ������ ��������� ������ ����� ��� ������� "pay.php" � "postlink.php" � ���������� � ���� �������.
����� �����!

-----===++[�� �������� �������������� �������� ����������:]++===-----
�� �������� �������������� �������� ����������:
��� "SOIUS", http:\\www.soius.kz
����� �������(tecc@mail.kz;soius@soius.kz)
010000, ���������� ���������, �.������, ����������� 56, �. 20
��������: 8(3172)295-290 ���������� 4, 8(3172)396-354 ���������� 4
�������: +7(701)382-76-13
ICQ:47191842
-----===++[===============================================]++===-----