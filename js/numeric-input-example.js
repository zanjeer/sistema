/* global $ */
/* this is an example for validation and change events */
$.fn.numericInputExample = function () {
	'use strict';
	var element = $(this),
		footer = element.find('tfoot tr'),
		dataRows = element.find('tbody tr'),
		initialTotal = function () {
			var column, total, a;
			// se recorren todas las filas
			dataRows.each(function () {
				total = 0;
				var row = $(this);	// row = fila actual
				for (column = 1; column < row.children().size()-1; column++) {  // size()-1 para no cantar el ultimo
						total += parseFloat(row.children().eq(column).text()); // eq = posicion en la fila
						 // console.log("numero c " + column);
				};
				row.children().eq(column).text(total/(column-1)); // se guarda el promedio en la ultima columna de la fila
				// console.log(total/(column-1) + " row , c=" + column);
			});
		};
	element.find('td').on('change', function (evt) {
		var cell = $(this),
			column = cell.index(),
			row,
			total = 0;
		if (column === 0) {
			return;
		}
		element.find('tbody tr').each(function () {
			row = $(this);
			total = 0;

			for (column = 1; column < row.children().size()-1; column++) {  // size()-1 para no cantar el ultimo
					total += parseFloat(row.children().eq(column).text()); // eq = posicion en la fila
			};

			total = total/(column-1);

			if (total > 7.0) {  // aka esta el total permitido
				 $('.alert').show();
				 return false; // changes can be rejected
			} else {
				$('.alert').hide();
				row.children().eq(column).text(total); 
			}
		});
	}).on('validate', function (evt, value) {
		var cell = $(this),
			column = cell.index();
		if (column === 0) {
			return !!value && value.trim().length > 0;
		} else {
			if(!isNaN(parseFloat(value)) && isFinite(value)){
				if( value <= 7.0 && value >= 1){  // antes de preguntar su valor, me aseguro  que es un numero
					return true;
				}else{  
					console.log(value);
					return false;}
			} else {
				console.log(value);
				return false; } 
		}
	});
	initialTotal();
	return this;
};
