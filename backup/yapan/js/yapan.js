function rn(){
        return (Math.floor( Math.random()* (1+40-20) ) ) + 20;
}
function formatNumber(input)
{
    var num = input.value.replace(/\,/g,'');
    if(!isNaN(num)){
    if(num.indexOf('.') > -1){
    num = num.split('.');
    num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
    if(num[1].length > 2){
    alert('You may only enter two decimals!');
    num[1] = num[1].substring(0,num[1].length-1);
    } input.value = num[0]+'.'+num[1];
    } else{ input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'') };
    }
    else{ alert('Anda hanya diperbolehkan memasukkan angka!');
    input.value = input.value.substring(0,input.value.length-1);
    }
}
$(function () {

    var data = [[1,rn()],[2,rn()],[3,rn()],[4,rn()],[5,rn()],[6,rn()],[7,rn()],[8,rn()],[9,rn()],[10,rn()],[11,rn()],[12,rn()]];
    $(".sparkline").sparkline(data,{
        width: '100%',
        height: 50,
        fillColor: 'transparent',
    });

    i=1;
    for (i=1; i<=3; i++) {
        data = [rn(),rn(),rn(),rn(),rn(),rn(),rn(),rn(),rn(),rn(),rn()];
        $(".stat-monthly-"+i).sparkline(data,{
            width: '100%',
            height: 50,
            fillColor: '#efefef',
            spotRadius: 2
        });
    } 

    $(".stat-bullet").sparkline([225,130,250,175,150,50], {
        type: 'bullet',
        width: '100%',
        height: 70,
        targetColor: '#468847',
        performanceColor: '#b94a48',
        rangeColors: ['#dff0d8','#fcf8e3','#f2dede','#b94a48']
    });
    
});
$(function(){
    // link to pages instead of tabs
    $('.tab-page').click(function(){
        var _url = $(this).attr('href');
        location.href = _url;
    });
// Redactor Wysiwyg
    $('#editor').redactor();
    $('#GBPP').redactor();
    $('#SAP').redactor();
});
$(document).ready(function() {
      colorpicker.init();
$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});

    });
 colorpicker = {
        init: function() {
            if($('#cp1').length) {
                $('#cp1').colorpicker({
                    format: 'hex'
                })
            }
        }
    };