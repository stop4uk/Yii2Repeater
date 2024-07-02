/**
 * @author relbraun <https://github.com/relbraun>
 * @source https://github.com/relbraun/yii2-repeater
 *
 * @author stop4uk <stop4uk@yandex.ru>
 * @source https://github.com/stop4uk/Yii2Repeater
 *
 * @version 1.0
 */
$(function($){
    var Repeater = function(rData){
        var self = this,
            widgetID = rData.widgetID,
            template = rData.template,
            innerData = rData.innerData,
            appendAction = rData.appendAction,
            removeAction = rData.removeAction,
            lastIndex = Number($(".repeater-item_" + widgetID + ":last").attr("data-id"));

        lastIndex++;
        this.id = lastIndex;
        this.archive = [];

        $wrap = $('.ab-repeater_' + widgetID + ' .list-area');
        $('.new-repeater_' + widgetID).click(function(e){
            e.preventDefault();

            let data = {
                id: self.id,
                widgetID: widgetID,
                template: template,
                additionalInformation: additionalInformation,
                additionalData: $('.repeater-item_' + widgetID).find('input,select,textarea').serialize()
            };

            data[yii.getCsrfParam()]=yii.getCsrfToken();
            $.post(appendAction, data, function(data) {
                let insertData = (
                    (template == 'table')
                        ? '<tr>' + data + '</tr>'
                        : data
                );

                $wrap.append(insertData);
            });

            self.id++;
        });

        $(document).on('click', '.repeater-item_' + widgetID + ' .copy', function(e){
            e.preventDefault();

            let elementsForChange = [],
                areaForFindElements = $(this).parents('.repeater-item_' + widgetID),
                data = {
                    id: self.id,
                    widgetID: widgetID,
                    template: template,
                    additionalInformation: additionalInformation,
                    additionalData: $('.repeater-item_' + widgetID).find('input,select,textarea').serialize()
                };

            data[yii.getCsrfParam()]=yii.getCsrfToken();
            $.post(appendAction, data, function(data) {
                let insertData = (
                    (template == 'table')
                        ? '<tr>' + data + '</tr>'
                        : data
                );

                $wrap.append(insertData);

                areaForFindElements.find('input,select,textarea').not('.noncopyable').each(function(){
                    let elementKey = $(this).attr('id').replace(/\-\d+\-/, "\-" + (self.id-1) + "\-"),
                        elementValue = $(this).val();

                    $("#" + elementKey).val(elementValue).trigger('change');
                });
            });

            self.id++;
        });

        $(document).on('click', '.repeater-item_' + widgetID + ' .remove', function(){
            self.archive.push($(this).parents('.repeater-item_' + widgetID).clone());
            var $item = $(this).parents('.repeater-item_' + widgetID),
                data ={id:$item.data('id')};

            $.post(removeAction,data, function(data){
                $item.remove();
            });
        });
    };

    window.repeater = Repeater;
});
