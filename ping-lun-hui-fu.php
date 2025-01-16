<?php
/**
 * Plugin Name:  [Yunsen2025的小窝]评论回复
 * Description: 一个邮件通知评论者收到回复的插件
 * Version: 1.0
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
      <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; border-radius:5px;">
        <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
        <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />'
         . trim(get_comment($parent_id)->comment_content) . '</p>
        <p>' . trim($comment->comment_author) . ' 给您的回复:<br />'
         . trim($comment->comment_content) . '<br /></p>
        <p>您可以点击 <a href="' . $comment_link . '">查看回复完整内容</a></p>
        <p>欢迎再度光临 ' . get_option('blogname') . '</p>
        <p>(此邮件由系统自动发送，请勿回复.)</p>
      </div>';
   
      $headers = array(
        'Content-Type: text/html; charset=' . get_option('blog_charset'),
        'From: "' . get_option('blogname') . '" <' . $wp_email . '>'
      );
   
      wp_mail($to, $subject, $message, $headers);
    }
  }
  add_action('comment_post', 'my_comment_mail_notify');