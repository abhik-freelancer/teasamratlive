// 
//		 window.alert = (function() {
//			var nativeAlert = window.alert;
//			return function(message) {
//				window.alert = nativeAlert;
//				message.indexOf("DataTables warning") === 0 ?
//					console.warn(message) :
//					nativeAlert(message);
//			}
//		})();