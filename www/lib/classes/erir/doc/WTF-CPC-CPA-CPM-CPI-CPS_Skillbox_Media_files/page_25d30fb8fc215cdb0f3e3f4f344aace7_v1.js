
; /* Start:"a:4:{s:4:"full";s:88:"/local/templates/.default/components/bitrix/news.detail/article/script.js?16672923283238";s:6:"source";s:73:"/local/templates/.default/components/bitrix/news.detail/article/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
$(function () {

    /**
     * Like CNT
     */
    !function () {

        var fbDef = $.Deferred();
        var vkDef = $.Deferred();
        var location = window.location.protocol + '//' + window.location.host + window.location.pathname;

        /** FB */
        $.getJSON(
            "https://graph.facebook.com/" + location,
            function (data) {
                fbDef.resolve(data && data.share ? parseInt(data.share.share_count || 0, 10) : 0);
            }
        );

        /** VK */
        window.VK = {Share: {}};
        window.VK.Share.count = function (index, count) {
            vkDef.resolve(parseInt(count || 0, 10));
        };
        $.getJSON("https://vk.com/share.php?act=count&index=1&format=json&callback=?&" + $.param({url: location}));

        $.when(fbDef, vkDef).done(function (fbCnt, vkCnt) {
            $(".js-fb_soc_counter").text(fbCnt); // FB
            $(".js-vk_soc_counter").text(vkCnt); // VK
            $('.js-twitter_soc_counter').text(Math.floor((fbCnt + vkCnt) / 2.5)); // Twitter
        });
    }();

    $(document).on('click', '.js-like-item', function (e) {
        var _this = $(this);
        $.ajax({
            url: '/local/ajax/setLike.php',
            type: 'POST',
            data: {
                action: _this.attr('data-action'),
                id: _this.attr('data-id'),
                type: _this.attr('data-type'),
            },
            dataType: 'json',
            success: function (data) {
                if (data.status == 'ok') {
                    if (data.action == 'comment') {
                        var _count_block = _this.parents('.comments__action').first().find('.like__count');
                        _count_block.html(data.count);
                        if (data.count > 0) {
                            _count_block.removeClass('negative').addClass('positive');
                        } else if (data.count < 0) {
                            _count_block.removeClass('positive').addClass('negative');
                        } else {
                            _count_block.removeClass('negative').removeClass('positive');
                        }
                        _this.parents('.like').first().find('.js-like-item').removeClass('evaluation_negative').removeClass('evaluation_positive');
                        if (data.type == 'down') {
                            _this.addClass('evaluation_negative');
                        } else {
                            _this.addClass('evaluation_positive');
                        }
                    } else if (data.action == 'article') {
                        $('.js-article-like-value').each(function (i, el) {
                            var $votes = parseInt($(el).text());
                            $votes++;
                            $(this).html($votes);
                        });
                        
                        $('.js-icon-like').addClass('voted');
                        _this.parent().text('Спасибо');
                    }
                }
            }
        });
        return false;
    });

    $(document).on('click', '.js-icon-like', function () {
        $('.js-like-item').trigger('click');
    });
});


/* End */
;; /* /local/templates/.default/components/bitrix/news.detail/article/script.js?16672923283238*/
