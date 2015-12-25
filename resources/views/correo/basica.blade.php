<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Notification email template</title>
</head>

<body bgcolor="#8d8e90">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#8d8e90">
    <tr>
        <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="61"><a href= "{{ Request::root()  }}" target="_blank"><img src="<?php echo $message->embed(Config::get("app.url")."/img/PROMO-GREEN2_01_01.jpg");?>" width="61" height="76" border="0" alt=""/></a></td>
                                <td width="144"><a href= "{{ Request::root()  }}" target="_blank"><img src="<?php echo $message->embed(Config::get("app.url")."/img/tiquesologo.jpg");?>" width="144" height="76" border="0" alt=""/></a></td>
                                <td width="393"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td height="46" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <!--<td width="67%" align="right"><font style="font-family:'Myriad Pro', Helvetica, Arial, sans-serif; color:#68696a; font-size:8px; text-transform:uppercase"><a href= "http://yourlink" style="color:#68696a; text-decoration:none"><strong>SEND TO A FRIEND</strong></a></font></td>
                                                        <td width="29%" align="right"><font style="font-family:'Myriad Pro', Helvetica, Arial, sans-serif; color:#68696a; font-size:8px"><a href= "http://yourlink" style="color:#68696a; text-decoration:none; text-transform:uppercase"><strong>VIEW AS A WEB PAGE</strong></a></font></td>-->
                                                        <td width="4%">&nbsp;</td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                        <tr>
                                            <td height="30"><img src="<?php echo $message->embed(Config::get("app.url")."/img/PROMO-GREEN2_01_04.jpg");?>" width="393" height="30" border="0" alt=""/></td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td align="center">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="10%">&nbsp;</td>
                                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, 'Times New Roman', Times, serif; color:#010101; font-size:24px"><strong><em>{!!  @$titulo  !!}</em></strong></font><br /><br />
                                    <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
                                        {!!  @$contenido  !!}
                                    </font>
                                </td>
                                <td width="10%">&nbsp;</td>
                            </tr>
                            <!--<tr>
                                <td>&nbsp;</td>
                                <td align="right" valign="top"><table width="108" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td><img src="/img/PROMO-GREEN2_04_01.jpg" width="108" height="9" style="display:block" border="0" alt=""/></td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" bgcolor="#6ebe44"><font style="font-family: Georgia, 'Times New Roman', Times, serif; color:#ffffff; font-size:14px"><em><a href="http://yourlink" target="_blank" style="color:#ffffff; text-decoration: underline">click here</a></em></font></td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" bgcolor="#6ebe44"><font style="font-family: Georgia, 'Times New Roman', Times, serif; color:#ffffff; font-size:15px"><strong><a href="http://yourlink" target="_blank" style="color:#ffffff; text-decoration:none"><em>LOREM</em></a></strong></font></td>
                                        </tr>
                                        <tr>
                                            <td height="10" align="center" valign="middle" bgcolor="#6ebe44"> </td>
                                        </tr>
                                    </table></td>
                                <td>&nbsp;</td>
                            </tr>-->
                        </table></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><img src="<?php echo $message->embed(Config::get("app.url")."/img/PROMO-GREEN2_07.jpg");?>" width="598" height="7" style="display:block" border="0" alt=""/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center"><font style="font-family:'Myriad Pro', Helvetica, Arial, sans-serif; color:#231f20; font-size:8px"><strong>Todos los derechos reservados {{ date("Y") }}	&copy; | <a href= "mailto:tiquesocoprolac@gmail.com" style="color:#010203; text-decoration:none">tiquesocoprolac@gmail.com</a></strong></font></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table></td>
    </tr>
</table>
</body>
</html>
