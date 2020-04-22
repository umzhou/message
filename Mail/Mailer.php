<?php

namespace Message\Mail;

use PHPMailer;

/**
 * 邮件通知类
 * Class Mailer
 * @package VlinkedUtils\Message
 */
class Mailer
{
    /**
     * @param MailConfig $mailConfig
     * @param MailMessage $mailMessage
     * @throws \phpmailerException
     */
    public static function sendMail($mailConfig, $mailMessage,$isHtml = false)
    {
        //实例化PHPMailer核心类
        $mail = new PHPMailer();
        //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = 1;

        //使用smtp鉴权方式发送邮件
        $mail->isSMTP();

        //smtp需要鉴权 这个必须是true
        $mail->SMTPAuth = true;

        //链接qq域名邮箱的服务器地址
        $mail->Host = $mailConfig->getHost();

        //设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = $mailConfig->getSecure();

        //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
        $mail->Port = $mailConfig->getPort();

        //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
        $mail->Hostname = $mailConfig->getUseraname();

        //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->CharSet = 'UTF-8';

        //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = $mailConfig->getUseraname();

        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username = $mailConfig->getUseraname();

        //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
        $mail->Password = $mailConfig->getPasword();

        //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From = $mailConfig->getUseraname();

        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false

        //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
        foreach ($mailMessage->getRecevie() as $k => $v) {
            $mail->addAddress($v, $mailConfig->getUseraname()); //添加收件人（地址，昵称）
            $mail->isHTML($isHtml); //支持html格式内容
            $mail->Subject = $mailMessage->getTitle();//邮件主题
            if($isHtml){
                $body = self::HtmlMail($mailMessage->getTitle(),$mailMessage->getContent());
                $mail->Body = $body;
            }else{
                $mail->Body = $mailMessage->getContent(); //邮件主体内容
            }

            $staus =      $mail->send();
            if(!$staus){
                throw  new \Exception("发送失败".$staus);
            }
        }
    }

    public static function HtmlMail($title,$content){        $html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">
<head>
	<!--[if gte mso 9]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\" />
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\" />
	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" />
	<meta name=\"format-detection\" content=\"date=no\" />
	<meta name=\"format-detection\" content=\"address=no\" />
	<meta name=\"format-detection\" content=\"telephone=no\" />
	<meta name=\"x-apple-disable-message-reformatting\" />
	<!--[if !mso]><!-->
	<link href=\"https://fonts.googleapis.com/css?family=Fira+Mono:400,500,700|Ubuntu:400,400i,500,500i,700,700i\" rel=\"stylesheet\" />
	<!--<![endif]-->
	<title></title>
	<!--[if gte mso 9]>
	<style type=\"text/css\" media=\"all\">
		sup { font-size: 100% !important; }
	</style>
	<![endif]-->


	<style type=\"text/css\" media=\"screen\">
		/* Linked Styles */
		body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#ccc; -webkit-text-size-adjust:none }
		a { color:#000001; text-decoration:none }
		p { padding:0 !important; margin:0 !important }
		img { -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer */ }
		.mcnPreviewText { display: none !important; }

		/* Mobile styles */
		@media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
			.mobile-shell { width: 100% !important; min-width: 100% !important; }

			.m-center { text-align: center !important; }
			.text3,
			.text-footer,
			.text-header { text-align: center !important; }

			.center { margin: 0 auto !important; }

			.td { width: 100% !important; min-width: 100% !important; }

			.m-br-15 { height: 15px !important; }
			.p30-15 { padding: 30px 15px !important; }
			.p30-15-0 { padding: 30px 15px 0px 15px !important; }
			.p40 { padding-bottom: 30px !important; }
			.box,
			.footer,
			.p15 { padding: 15px !important; }
			.h2-white { font-size: 40px !important; line-height: 44px !important; text-align: center !important; }

			.h2 { font-size: 42px !important; line-height: 50px !important; }

			.m-td,
			.m-hide { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; min-height: 0 !important; }

			.m-block { display: block !important; }
			.container { padding: 0px !important; }
			.separator { padding-top: 30px !important; }

			.fluid-img img { width: 100% !important; max-width: 100% !important; height: auto !important; }

			.column,
			.column-top,
			.column-dir,
			.column-empty,
			.column-empty2,
			.column-bottom,
			.column-dir-top,
			.column-dir-bottom { float: left !important; width: 100% !important; display: block !important; }

			.column-empty { padding-bottom: 10px !important; }
			.column-empty2 { padding-bottom: 30px !important; }

			.content-spacing { width: 15px !important; }
		}
	</style>
</head>
<body class=\"body\" style=\"padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#ccc; -webkit-text-size-adjust:none;\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#ccc\">
	<tr>
		<td align=\"center\" valign=\"top\" class=\"container\" style=\"padding:50px 10px;\">
			<!-- Container -->
			<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				<tr>
					<td align=\"center\">
						<table width=\"650\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"mobile-shell\">
							<tr>
								<td class=\"td\" bgcolor=\"#ffffff\" style=\"width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;\">
									<!-- Header -->
									<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"transparent\">
										<tr>
											<td class=\"p30-15-0\" style=\"padding: 40px 30px 0px 30px;\">
												<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
													<tr>
														<th class=\"column\" style=\"font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;\">
															<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
																<tr>
																	<td class=\"img m-center\" style=\"font-size:0pt; line-height:0pt; text-align:left;\"><img src=\"https://cdn.opapp.cn/icbc/company_logo.png\" width=\"200\" height=\"\" editable=\"true\" border=\"0\" alt=\"\" /></td>
																</tr>
															</table>
														</th>
														<th class=\"column-empty\" width=\"1\" style=\"font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;\"></th>
														<th class=\"column\" width=\"120\" style=\"font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;\">
															<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
																<tr>
																	<td class=\"text-header right\" style=\"color:#333; font-family:'Fira Mono', Arial,sans-serif; font-size:12px; line-height:16px; text-align:right;\"><multiline><a href=\"#\" target=\"_blank\" class=\"link\" style=\"color:#333; text-decoration:none;\"><span class=\"link\" style=\"color:#333; text-decoration:none;\"></span></a></multiline></td>
																</tr>
															</table>
														</th>
													</tr>
												</table>
												<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
													<tr>
														<td class=\"separator\" style=\"padding-top: 40px; border-bottom:4px solid #ffd31a; font-size:0pt; line-height:0pt;\">
														</td>
													
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<!-- END Header -->

									<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#ffffff\">
										<tbody>
											<tr>
												<td class=\"p30-15\" style=\"padding: 20px 30px 20px 30px;\">
												<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
													<tbody style=\"line-height: 26px;\">
														<tr>
															<td class=\"h2 center pb10\" style=\"color:#333; font-family:'Ubuntu', Arial,sans-serif; font-size:24px;text-align:left; padding:15px 0 20px 0;\">
																$title
															</td>
														</tr>
														<tr>
															<td class=\"h4 center pb10\" style=\"color:#333; font-family:'Ubuntu', Arial,sans-serif; font-size:18px;text-align:left; padding-bottom:10px;\">
																$content
															</td>
														</tr>
													</tbody>
												</table>
												</td>
											</tr>
										</tbody>
									</table>

									<!-- Footer -->
									<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
										<tr>
											<td class=\"footer\" style=\"padding: 0px 30px 30px 30px;\">
												<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
													<tr>
														<td class=\"pb40\" style=\"padding-bottom:40px;\"></td>
													</tr>
													<tr>
														<td class=\"text-socials\" style=\"color:#333; font-family:'Fira Mono', Arial,sans-serif; font-size:16px; line-height:22px; text-align:center; text-transform:uppercase;\">
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<!-- END Footer -->
								</td>
							</tr>
							<tr>
								<td class=\"text-footer\" style=\"padding: 30px 15px; color:#333; font-family:'Fira Mono', Arial,sans-serif; font-size:12px; line-height:22px; text-align:center;\">
									<multiline>Copyright @2015-2020 VLINKED.  All Rights Reserved.</multiline>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<!-- END Container -->
		</td>
	</tr>
</table>
</body>
</html>
";
    return $html;
    }

}
