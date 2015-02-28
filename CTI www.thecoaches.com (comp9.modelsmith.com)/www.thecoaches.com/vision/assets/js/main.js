			//<![CDATA[
			$(document).ready(function(){

				$("#jquery_jplayer_1").jPlayer({
					ready: function (event) {
						$(this).jPlayer("setMedia", {
							mp3:"http://www.thecoaches.com/vision/assets/js/libs/media/Disorienting-Event.mp3",
							m4a:"http://www.thecoaches.com/vision/assets/js/libs/media/Disorienting-Event.m4a",
							oga:"http://www.thecoaches.com/vision/assets/js/libs/media/Disorienting-Event.ogg"
						});
					},
					play: function() { // To avoid multiple jPlayers playing together.
						$(this).jPlayer("pauseOthers");
					},
					swfPath: "libs",
					supplied: "mp3, m4a, oga",
					wmode: "window",
					smoothPlayBar: true,
					keyEnabled: true
				});
			
				$("#jplayer_inspector_1").jPlayerInspector({jPlayer:$("#jquery_jplayer_1")});
				
				$("#jquery_jplayer_2").jPlayer({
					ready: function (event) {
						$(this).jPlayer("setMedia", {
							mp3:"http://www.thecoaches.com/vision/assets/js/libs/media/The-Struggle.mp3",
							m4a:"http://www.thecoaches.com/vision/assets/js/libs/media/The-Struggle.m4a",
							oga:"http://www.thecoaches.com/vision/assets/js/libs/media/The-Struggle.ogg"
						});
					},
					play: function() { // To avoid multiple jPlayers playing together.
						$(this).jPlayer("pauseOthers");
					},
					swfPath: "libs",
					supplied: "mp3, m4a, oga",
					wmode: "window",
					cssSelectorAncestor: "#jp_container_2",
					smoothPlayBar: true,
					keyEnabled: true
				});
			
				$("#jplayer_inspector_2").jPlayerInspector({jPlayer:$("#jquery_jplayer_2")});
				
				$("#jquery_jplayer_3").jPlayer({
					ready: function (event) {
						$(this).jPlayer("setMedia", {
							mp3:"http://www.thecoaches.com/vision/assets/js/libs/media/Discovery-Of-The-Code.mp3",
							m4a:"http://www.thecoaches.com/vision/assets/js/libs/media/Discovery-Of-The-Code.m4a",
							oga:"http://www.thecoaches.com/vision/assets/js/libs/media/Discovery-Of-The-Code.ogg"
						});
					},
					play: function() { // To avoid multiple jPlayers playing together.
						$(this).jPlayer("pauseOthers");
					},
					swfPath: "libs",
					supplied: "mp3, m4a, oga",
					wmode: "window",
					cssSelectorAncestor: "#jp_container_3",
					smoothPlayBar: true,
					keyEnabled: true
				});
			
				$("#jplayer_inspector_3").jPlayerInspector({jPlayer:$("#jquery_jplayer_3")});
				
				$("#jquery_jplayer_4").jPlayer({
					ready: function (event) {
						$(this).jPlayer("setMedia", {
							mp3:"http://www.thecoaches.com/vision/assets/js/libs/media/A-New-World.mp3",
							m4a:"http://www.thecoaches.com/vision/assets/js/libs/media/A-New-World.m4a",
							oga:"http://www.thecoaches.com/vision/assets/js/libs/media/A-New-World.ogg"
						});
					},
					play: function() { // To avoid multiple jPlayers playing together.
						$(this).jPlayer("pauseOthers");
					},
					swfPath: "libs",
					supplied: "mp3, m4a, oga",
					wmode: "window",
					cssSelectorAncestor: "#jp_container_4",
					smoothPlayBar: true,
					keyEnabled: true
				});
			
				$("#jplayer_inspector_4").jPlayerInspector({jPlayer:$("#jquery_jplayer_4")});
				
				jPlayer({
				    "solution": navigator.userAgent.indexOf("Trident/5")>-1 ? "flash" : "html,flash"
				}) 
			
			});
			//]]>
		
