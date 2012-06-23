$(function(){
	
	switcher.init();
	
	if ($('#chat').size())
	{
		chatGetLast();
	}
	
	$('#chat form').bind('submit', function(){
		var name = $('#c_name').val();
		var text = $('#c_text').val();
		
		if ('' == name || '' == text)
			return false;
		
		$.ajax(
		{
			type: 'POST',
			url: '/chat/post',
			data: 'name=' + encodeURIComponent( name ) + '&text=' + encodeURIComponent( text ),
			dataType: 'json',
			success: function(r)
			{
				chatRender(r.chats);
				chatResetTimeout();
			}
		});
		
		$('#c_text').val('');
	});
	
	$('#video_comment_form form').bind('submit', function(){
		var name = $('#name').val();
		var text = $('#text').val();
		var captchaId = $('#captcha-id').val();
		var captchaInput = $('#captcha-input').val();
		var id = $('#video_comments').attr('videoid');
		
		if ('' == name || '' == text)
			return false;
		
		$.ajax(
		{
			type: 'POST',
			url: '/video/postcomment',
			data: 'name=' + encodeURIComponent( name )
				+ '&text=' + encodeURIComponent( text )
				+ '&id=' + encodeURIComponent( id )
				+ '&captcha[id]=' + encodeURIComponent( captchaId )
				+ '&captcha[input]=' + encodeURIComponent( captchaInput ),
			dataType: 'json',
			success: function(r)
			{
				videoCommentsLoad(id);
			}
		});
		
		$('#text').val('');
	});
	
	$('#cimg,.captcha img').bind('click', function(){
		$.ajax(
		{
			type: 'POST',
			url: '/index/refresh-captcha',
			dataType: 'json',
			success: function(r)
			{
				$('#captcha-id').val(r.captcha);
				$('.captcha img').attr('src', '/img/captcha/'+r.captcha+'.png');
				$('#cimg').attr('src', '/img/captcha/'+r.captcha+'.png');
			}
		});
	});
});

function videoCommentsLoad(id)
{
	$.ajax(
	{
		type: 'POST',
		url: '/video/listcomments',
		dataType: 'json',
		data: 'id=' + encodeURIComponent( id ),
		success: function(r)
		{
			videoCommentsRender(r);
		}
	});
}

function videoCommentsRender(r)
{
	var comments = r.comments;
	var html = '';
	for (var i in comments)
	{
		html += '<div class="item"><div class="lineelement comment-date-name">';
		html += '<div class="comment-name">'+ comments[i].name+'</div> <div class="comment-date">' + comments[i].time + '</div>';
		html += '</div>';
		html += '<div class="comment-text lineelement">' + comments[i].text + '</div>';
		html += '<div class="clear"></div>';
		html += '</div>';
	}

	$('#captcha-id').val(r.captcha);
	$('#cimg').attr('src', '/img/captcha/'+r.captcha+'.png');
	$('#video_comments').html(html);
	$('#video_comments').attr('videoid', r.id);
}

function videoCommentsPost()
{
	var comments = r.comments;
	var html = '';
	for (var i in comments)
	{
		html += '<div class="comment">';
		html += '<div class="msghead"><span class="time">' + comments[i].time + '</span>' + comments[i].name + '</div>';
		html += '<div class="msgtext">' + comments[i].text + '</div>';
		html += '</div>';
	}

	$('#video_comments').html(html);
	$('#video_comments').attr('videoid', r.id);
}

chatTimeout = null;

function chatResetTimeout()
{
	clearTimeout(chatTimeout);
	chatTimeout = setTimeout(chatGetLast, 10000);
}

function chatGetLast()
{
	$.ajax(
	{
		type: 'POST',
		url: '/chat/list',
		dataType: 'json',
		success: function(r)
		{
			chatRender(r.chats);
		}
	});
	chatResetTimeout();
}

function chatRender(chats)
{
	var html = '';
	for (var i in chats)
	{
		html += '<div class="message">';
		html += '<div class="msghead"><span class="time">' + chats[i].time + '</span>' + chats[i].name + '</div>';
		html += '<div class="msgtext">' + chats[i].text + '</div>';
		html += '</div>';
	}

	$('#chat .messages').html(html);
}

var switcher =
{
	timeout: null,
	init : function ()
	{
		$('.last-news-switcher a').click(function(){
			var a = $(this);
			var collection = a.parent().children();
			var switchIndex = collection.index(a);
			switcher.switchLastNews(switchIndex);
			return false;
		});
		switcher.switchLastNews(0);
	},
	switchLastNews : function (i)
	{
		$('.last-news-frame-container').each(function(){
			var activate = $(this).find('.last-news-frame').eq(i);
			var deactivate = $(this).find('.last-news-frame').not(activate);
			activate.stop(true).css({opacity:'1', display:'none'}).fadeIn(300);
			deactivate.stop(true).fadeOut(300);
		});
		$('.last-news-switcher a.active').removeClass('active');
		$('.last-news-switcher a').eq(i).addClass('active');
		switcher.resetTimeout();
	},
	switchNext : function ()
	{
		var a = $('.last-news-switcher a.active');
		var collection = a.parent().children();
		var switchIndex = collection.index(a);
		switcher.switchLastNews((switchIndex+1)%6);
	},
	resetTimeout : function ()
	{
		clearTimeout(switcher.timeout);
		switcher.timeout = setTimeout(switcher.switchNext, 5000);
	}
}
