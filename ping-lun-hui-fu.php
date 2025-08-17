<?php
/**
 * Plugin Name:  [Yunsen2025的小窝]评论回复
 * Description: 一个邮件通知评论者收到回复的插件
 * Version: 2.1
 * Author: <a href="https://www.yunsen2025.top" target="_blank">Yunsen2025</a>
 * Author URI: https://www.yunsen2025.top
 */
function my_comment_mail_notify($comment_id) {
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $spam_confirmed = $comment->comment_approved;
   
    if (($parent_id != '') && ($spam_confirmed != 'spam')) {
      $wp_email = 'blog@yunsen2025.top'; // 发件人邮箱
      $to = trim(get_comment($parent_id)->comment_author_email);
      $subject = '您在 [' . get_option("blogname") . '] 的留言有了回复';
      $comment_link = get_comment_link($comment_id); // 获取评论链接
      $message = '
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>评论回复通知</title>
</head>
<body style="margin:0; padding:20px; font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; background-color:#f0f2f5;">
  <table style="max-width:900px; margin:0 auto; background-color:#ffffff; border-radius:12px; border-collapse:collapse; width:100%; overflow:hidden;">
    
    <!-- 信任提示框 -->
    <tr>
      <td style="background: linear-gradient(135deg, #fff3e0, #ffe0b2); padding:20px 30px; border-bottom:1px solid #ffcc02;">
        <table style="width:100%; border-collapse:collapse;">
          <tr>
            <td style="width:50px; text-align:center;">
              <div style="width:40px; height:40px; background:#ff9800; border-radius:50%; text-align:center; line-height:40px; color:white; font-size:18px; font-weight:600;">
                🔒
              </div>
            </td>
            <td style="padding-left:15px;">
              <h3 style="margin:0 0 5px 0; color:#e65100; font-size:16px; font-weight:600;">
                <span>📧</span> 为了获得最佳阅读体验
              </h3>
              <p style="margin:0; color:#bf360c; font-size:14px; line-height:1.5;">
                如果您看不到图片或样式异常，请在邮箱中：<br>
                • <strong>添加发件人到信任列表</strong> &nbsp;&nbsp; • <strong>允许显示图片</strong> &nbsp;&nbsp; • <strong>启用HTML格式</strong><br>
                （Gmail安全策略可能会导致图片无法加载/格式错乱，属正常现象）
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    
    <!-- 头部横幅 -->
    <tr>
      <td style="background: #009688; padding:40px 30px;">
        <table style="width:100%; border-collapse:collapse;">
          <tr>
            <td style="width:70%;">
              <table style="border-collapse:collapse;">
                <tr>
                  <td style="padding-right:20px;">
                    <div style="width:60px; height:60px; border-radius:12px; border:2px solid rgba(255,255,255,0.3); position:relative; background:rgba(255,255,255,0.15); overflow:hidden;">
                      <span style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); color:#ffffff; font-size:24px; font-weight:600; z-index:1;">Y</span>
                      <img src="https://blogimgcdn.236668.xyz/2025/06/20250614102401954.png" style="position:absolute; top:2px; left:2px; width:calc(100% - 4px); height:calc(100% - 4px); object-fit:cover; border-radius:8px; z-index:2;">
                    </div>
                  </td>
                  <td>
                    <h1 style="margin:0; color:#ffffff; font-size:28px; font-weight:600;">' . get_option('blogname') . '</h1>
                    <p style="margin:5px 0 0 0; color:#ffffff; opacity:0.9; font-size:16px;">纯粹的计算机爱好者</p>
                  </td>
                </tr>
              </table>
            </td>
            <td style="text-align:right; width:30%;">
              <h2 style="margin:0; color:#ffffff; font-size:24px; font-weight:600;">
                <span>💬</span> 您收到新回复啦！
              </h2>
              <p style="margin:10px 0 0 0; color:#ffffff; opacity:0.9; font-size:14px;">评论回复通知</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    
    <!-- 问候语 -->
    <tr>
      <td style="padding:30px 40px 20px 40px;">
        <h2 style="margin:0 0 15px 0; color:#009688; font-size:22px; font-weight:400;">
          <span>👋</span> 亲爱的 <strong>' . trim(get_comment($parent_id)->comment_author) . '</strong>，您好！
        </h2>
        <p style="margin:0; color:#555; font-size:16px; line-height:1.7;">有人回复了您的评论，快来看看精彩的互动吧！</p>
      </td>
    </tr>
    
    <!-- 文章信息 -->
    <tr>
      <td style="padding:0 40px 25px 40px;">
        <div style="padding:20px; background: #e0f2f1; border-radius:10px; border-left:5px solid #009688;">
          <p style="margin:0; color:#004d40; font-size:16px; font-weight:600;">
            <span style="background:#009688; color:white; padding:4px 12px; border-radius:15px; font-size:12px; font-weight:500; margin-right:15px;">
              <span>📚</span> 文章
            </span>
            《' . get_the_title($comment->comment_post_ID) . '》
          </p>
        </div>
      </td>
    </tr>
    
    <!-- 原评论卡片 -->
    <tr>
      <td style="padding:0 40px 25px 40px;">
        <div style="background:#ffffff; border:2px solid #b2dfdb; border-radius:12px; overflow:hidden;">
          <div style="background: #e0f2f1; padding:15px 20px; border-bottom:1px solid #80cbc4;">
            <p style="margin:0; color:#009688; font-weight:600; font-size:14px;">
              <span>📝</span> 您的原评论
            </p>
          </div>
          <div style="padding:20px;">
            <p style="margin:0; color:#333; font-size:15px; line-height:1.6;">' . trim(get_comment($parent_id)->comment_content) . '</p>
          </div>
        </div>
      </td>
    </tr>
    
    <!-- 新回复卡片 -->
    <tr>
      <td style="padding:0 40px 30px 40px;">
        <div style="background:#ffffff; border:2px solid #4db6ac; border-radius:12px; overflow:hidden;">
          <div style="background: #b2dfdb; padding:15px 20px; border-bottom:1px solid #4db6ac;">
            <table style="width:100%; border-collapse:collapse;">
              <tr>
                <td style="width:40px; padding-right:12px;">
                  <div style="width:32px; height:32px; border-radius:50%; position:relative; background:#009688; overflow:hidden;">
                    <span style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); color:#ffffff; font-size:14px; font-weight:600; z-index:1;">' . strtoupper(substr(trim($comment->comment_author), 0, 1)) . '</span>
                    <img src="' . get_avatar_url($comment->comment_author_email, array('default' => 'identicon')) . '" style="position:absolute; top:0; left:0; width:32px; height:32px; object-fit:cover; border-radius:50%; z-index:2;" alt="头像">
                  </div>
                </td>
                <td>
                  <span style="color:#004d40; font-weight:700; font-size:14px;">' . trim($comment->comment_author) . '</span>
                  <br><span style="color:#666; font-size:11px;">回复了您</span>
                </td>
              </tr>
            </table>
          </div>
          <div style="padding:20px;">
            <p style="margin:0; color:#333; font-size:15px; line-height:1.6;">' . trim($comment->comment_content) . '</p>
          </div>
        </div>
      </td>
    </tr>
    
    <!-- 操作区域 -->
    <tr>
      <td style="text-align:center; padding:40px;">
        <a href="' . $comment_link . '" style="display:inline-block; background: #009688; color:#ffffff; text-decoration:none; padding:15px 40px; border-radius:30px; font-size:16px; font-weight:600;">
          查看完整对话
        </a>
      </td>
    </tr>
    
    <!-- 底部信息 -->
    <tr>
      <td style="background: #e0f2f1; padding:25px 40px; text-align:center;">
        <p style="margin:0 0 15px 0; color:#00695c; font-size:14px; font-weight:500;">
          <a href="https://www.yunsen2025.top" style="color:#00695c; text-decoration:none;">Yunsen2025的小窝——yunsen2025.top</a>
        </p>
        <p style="margin:0 0 10px 0; color:#00695c; font-size:13px;">感谢您的关注与支持，让我们一起创造更美好的交流体验！</p>
        <p style="margin:0; color:#004d40; font-size:11px;">此邮件由系统自动发送 | 请勿直接回复此邮件</p>
      </td>
    </tr>
    
  </table>
</body>
</html>';
   
      $headers = array(
        'Content-Type: text/html; charset=' . get_option('blog_charset'),
        'From: "' . get_option('blogname') . '" <' . $wp_email . '>'
      );
   
      wp_mail($to, $subject, $message, $headers);
    }
  }
  add_action('comment_post', 'my_comment_mail_notify', 10, 1);
