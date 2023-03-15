'use strict'
$(function () {
	dataTableLang = {
		"sLengthMenu": lang.GEN_DATATABLE_SLENGTHMENU,
		"sZeroRecords": lang.GEN_DATATABLE_SZERORECORDS,
		"sEmptyTable": lang.GEN_DATATABLE_SEMPTYTABLE,
		"sInfo": lang.GEN_DATATABLE_SINFO,
		"sInfoEmpty": lang.GEN_DATATABLE_SINFOEMPTY,
		"sInfoFiltered": lang.GEN_DATATABLE_SINFOFILTERED,
		"sInfoPostFix": lang.SETT_DATATABLE_SINFOPOSTFIX,
		"slengthMenu": lang.GEN_DATATABLE_SLENGTHMENU,
		"sSearch": lang.SETT_DATATABLE_SSEARCH,
		"sSearchPlaceholder": lang.GEN_DATATABLE_SSEARCHPLACEHOLDER,
		"sUrl": lang.SETT_DATATABLE_SSEARCH,
		"sInfoThousands": lang.SETT_DATATABLE_SINFOTHOUSANDS,
		"sProcessing": lang.GEN_DATATABLE_SPROCESSING,
		"sloadingrecords": lang.GEN_DATATABLE_SLOADINGRECORDS,
		"oPaginate": {
			"sFirst": lang.GEN_DATATABLE_SFIRST,
			"sLast": lang.GEN_DATATABLE_SLAST,
			"sNext": lang.SETT_DATATABLE_SNEXT,
			"sPrevious": lang.SETT_DATATABLE_SPREVIOUS
		},
		"oAria": {
			"sSortAscending": lang.GEN_DATATABLE_SSORTASCENDING,
			"sSortDescending": lang.GEN_DATATABLE_SSORTDESCENDING
		},
		"select": {
			"rows": {
				_: lang.GEN_DATATABLE_ROWS_SELECTED,
				0: lang.SETT_DATATABLE_ROWS_NO_SELECTED,
				1: lang.GEN_DATATABLE_ROW_SELECTED
			}
		}
	}

	currentDate = new Date();
  $.datepicker.regional['es'] = {
    closeText: lang.GEN_DATEPICKER_CLOSETEXT,
    prevText: lang.GEN_DATEPICKER_PREVTEXT,
    nextText: lang.GEN_DATEPICKER_NEXTTEXT,
    currentText: lang.GEN_DATEPICKER_CURRENTTEXT,
    monthNames: lang.GEN_DATEPICKER_MONTHNAMES,
    monthNamesShort: lang.GEN_DATEPICKER_MONTHNAMESSHORT,
    dayNames: lang.GEN_DATEPICKER_DAYNAMES,
    dayNamesShort: lang.GEN_DATEPICKER_DAYNAMESSHORT,
    dayNamesMin: lang.GEN_DATEPICKER_DAYNAMESMIN,
		weekHeader: lang.SETT_DATEPICKER_WEEKHEADER,
    dateFormat: lang.SETT_DATEPICKER_DATEFORMAT,
    firstDay: lang.SETT_DATEPICKER_FIRSTDATE,
    isRTL: lang.SETT_DATEPICKER_ISRLT,
		showMonthAfterYear: lang.SETT_DATEPICKER_SHOWMONTHAFTERYEAR,
		yearRange: lang.SETT_DATEPICKER_YEARRANGE + currentDate.getFullYear(),
		minDate: lang.SETT_DATEPICKER_MINDATE,
		maxDate: currentDate,
		changeMonth: lang.SETT_DATEPICKER_CHANGEMONTH,
    changeYear: lang.SETT_DATEPICKER_CHANGEYEAR,
		showAnim: lang.SETT_DATEPICKER_SHOWANIM,
    yearSuffix: lang.SETT_DATEPICKER_YEARSUFFIX
  };

	$.datepicker.setDefaults($.datepicker.regional['es']);
});
