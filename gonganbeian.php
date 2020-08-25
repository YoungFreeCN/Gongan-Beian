<?php
/*
Plugin Name: Gongan Beian
Plugin URI: https://www.youngfree.cn/seo/2214.html
Description: 用于 Wordpress 博客申请交互式公安网站备案合规化。该插件可按公安备案要求记录留言和评论用户的 IP 和端口号，以及精确到秒的时间。
Version: 1.0
Author: 杨景文
Author URI: https://www.yangjingwen.cn
*/

/*  Copyright since 2017  杨景文  (email : admin@youngfree.cn)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//IP端口 获取与存储
add_action('wp_insert_comment','yjwgaba_insert_ipport',10,2);
function yjwgaba_insert_ipport($comment_ID,$commmentdata) {
#	$userip = $_SERVER['HTTP_CLIENT_IP']; //
    $ipport = $_SERVER['REMOTE_PORT'];
    //ipport 是存储在数据库里的字段名字，取出数据的时候就会用到
#	update_comment_meta($comment_ID,'yjwgaba_userip',$userip);
    update_comment_meta($comment_ID,'yjwgaba_ipport',$ipport);
}
//为IP Port栏目添加CSS
function yjwgaba_ipport_css() {
?>
<style type="text/css">
	#yjwgaba_ipport { width: 50px; } /* CSS for ipport columns */
	#yjwgaba_userip { width: 50px; } /* CSS for ip columns */
	#author_ip { width: 80px; } /* CSS for ip columns */
</style>
<?php	
}
add_action('admin_head', 'yjwgaba_ipport_css');
//后台评论添加IP端口栏目
add_filter( 'manage_edit-comments_columns', 'yjwgaba_comments_columns' );
add_action( 'manage_comments_custom_column', 'output_yjwgaba_comments_columns', 10, 2 );
function yjwgaba_comments_columns( $columns ){
#	unset($columns['Time']);
#	$columns[ 'date' ] = ( 'Time2' );        //Time代表列的名字
#	$columns[ 'yjwgaba_userip' ] = yjwgaba_( 'User IP' );        //User IP代表列的名字
	$columns[ 'author_ip' ] = ( 'IP & Port & Time' );        //User IP代表列的名字
#    $columns[ 'yjwgaba_ipport' ] = yjwgaba_( 'IP Port' );        //IP Port代表列的名字
    return $columns;
}
function output_yjwgaba_comments_columns( $column_name, $comment_id ){
    switch( $column_name ) {
#		case "date" :
#		echo get_the_time( $comment_id, 'date', true );
#		echo get_comment_date(strtotime(get_the_time('Y-m-d G:i:s')));
#		break;
		case "author_ip" :
		echo get_comment_author_IP( $comment_id, 'author_ip', true ).' : '.get_comment_meta( $comment_id, 'yjwgaba_ipport', true ).'<br><br>'.get_comment_date('Y-m-d G:i:s',$comment_id);
		break;
#		case "yjwgaba_userip" :
#		echo get_comment_meta( $comment_id, 'yjwgaba_userip', true );
#		break;
#		case "yjwgaba_ipport" :
#		echo get_comment_meta( $comment_id, 'yjwgaba_ipport', true );
#		break;
	}
}
?>