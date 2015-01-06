var Process = React.createClass({

		getInitialState: function() {
		    return {data:[]};
		},


		loadStatusFromServer: function(){
			var self = this;
			$.ajax({
			     url: this.props.url,
			     dataType: 'json',
			     success: function(data) {
			     
			       this.setState({data: data});
				   self.draw(data);
			     }.bind(this),
			     error: function(xhr, status, err) {
			       console.error(this.props.url, status, err.toString());
			     }.bind(this)
			   });
		},

		handleResize: function(e) {
		  this.setState({windowWidth: window.innerWidth});
		},

		componentDidMount: function() {
		   this.loadStatusFromServer();
		   setInterval(this.loadStatusFromServer, this.props.pollInterval);
		},

		// componentDidMount: function() {
		//  	// window.addEventListener('resize', this.handleResize);
		// },

		drawRectangle: function(positionX, positionY){
			var rectangle = new paper.Rectangle(new paper.Point(20, 20), new paper.Size(60, 60));
			var shape = new paper.Shape.Rectangle(rectangle);
			shape.position = new paper.Point(positionX, positionY);
			shape.strokeColor = 'black';
		},

		drawText: function(positionX, positionY, content){
			var stateNameTxt = new paper.PointText(0, 0);
			stateNameTxt.content = content;
			stateNameTxt.name = 'stateNameTxt';
			stateNameTxt.position = new paper.Point(positionX,positionY);
		},

		drawLine:function(fromX, fromY, toX, toY, direction, color){
			var from = new paper.Point(fromX, fromY);
			var to   = new paper.Point(toX, toY);
			var path = new paper.Path.Line(from, to);

			if(direction != undefined){
				if (direction == 0){
					var arrawOne = new paper.Point(toX-5, toY-5);
					var arrawTwo = new paper.Point(toX-5, toY+5);
				}else if (direction == 1){
					var arrawOne = new paper.Point(toX-5, toY-5);
					var arrawTwo = new paper.Point(toX+5, toY-5);
				}else if (direction == 2) {
					var arrawOne = new paper.Point(toX-5, toY-5);
					var arrawTwo = new paper.Point(toX+5, toY-5);
				}else if (direction == 3) {
					var arrawOne = new paper.Point(toX-5, toY+5);
					var arrawTwo = new paper.Point(toX+5, toY+5);
				}
				
				var arrowPathOne = new paper.Path.Line(to, arrawOne);
				var arrowPathTwo = new paper.Path.Line(to, arrawTwo);
				arrowPathOne.strokeColor = 'black';
				arrowPathTwo.strokeColor = 'black';
			}

			if(color != undefined){
				path.strokeColor = color;
			}else{
				path.strokeColor = 'black';
			}
		},

		drawRole: function(positionX, positionY, name) {
			this.drawRectangle(positionX, positionY);
			this.drawText(positionX, positionY, name);
		},

		draw: function(data){
			var self = this;
			var canvas = document.getElementById('myCanvas');
			paper.setup(canvas);
			this.drawRole(40, 360, '销售员');
			this.drawRole(240, 360, '审计员');
			this.drawRole(240, 260, '仓库主管');
			this.drawRole(240, 460, '制作主管');
			this.drawRole(440, 360, '工艺下单员');
			this.drawRole(440, 460, '制作员');
			this.drawRole(540, 460, '检查员');
			this.drawRole(640, 460, '数码部');
			this.drawRole(340, 560, '排版员');
			this.drawRole(440, 160, '采购员');
			this.drawRole(240, 160, '总经办经理');
			this.drawRole(40, 160, '财务');
			this.drawRole(640, 160, '入库员');
			this.drawRole(540, 260, '外协员');
			this.drawRole(640, 260, '质量经理');
			this.drawRole(640, 360, '调度员');
			this.drawRole(540, 560, '检查员');
			this.drawRole(640, 560, '制作主管');
			this.drawRole(840, 360, '胶印主管');
			this.drawRole(840, 460, '外协员');
			this.drawRole(1040, 360, '机长');
			this.drawRole(1240, 360, '质量经理');
			this.drawRole(840, 560, '质量经理');
			this.drawRole(940, 560, '品检员');
			this.drawRole(1140, 560, '装订部');
			this.drawRole(1340, 560, '质量经理');
			this.drawRole(1340, 460, '品检员');
			this.drawRole(1340, 260, '仓库出货员');
			this.drawRole(1340, 160, '司机');
			this.drawRole(1140, 260, '审计员');
			this.drawRole(1140, 160, '销售员');
			this.drawLine(70,360,210,360, 0, 'red');//销售到审计
			
			$.each(data, function(index, value){
				// 0--x right, 1--y down, 2--x--left, 3--y up ,4 --no
				// self.drawLine(270,460,410,460,0);
				switch(value.connect_id){
					case '2'://审计到制作主管
						if(value.ended_at != 0){
							self.drawLine(240, 390, 240, 430, 1, 'red');
						}else{
							self.drawLine(240, 390, 240, 430, 1);
						}
						break;
					case '3'://审计到仓库主管
						if(value.ended_at != 0){
							self.drawLine(240, 330, 240, 290, 3, 'red');
						}else{
							self.drawLine(240, 330, 240, 290, 3);
						}
						break;
					case '4'://仓库主管到工艺下单员
						if(value.ended_at != 0){
							self.drawLine(270, 260, 440, 260, 'red');
							self.drawLine(440, 260, 440, 330, 1, 'red');
						}else{
							self.drawLine(270, 260, 440, 260);
							self.drawLine(440, 260, 440, 330, 1);
						}
						break;
					case '15':
						if(value.ended_at != 0){
							self.drawLine(270,460,410,460,0,'red');
						}else{
							self.drawLine(270,460,410,460,0);
						}
						break;
					case '18':
						if(value.ended_at != 0){
							self.drawLine(240, 490, 240, 560, undefined, 'red');
							self.drawLine(240, 560, 310, 560, 0, 'red');
						}else{
							self.drawLine(240, 490, 240, 560);
							self.drawLine(240, 560, 310, 560, 0);
						}
						break;
					case '39'://审计到工艺下单员
						if(value.ended_at != 0){
							self.drawLine(270, 360, 410, 360, 0, 'red');
						}else{
							self.drawLine(270, 360, 410, 360, 0);
						}
						break;
					default:
						// console.log('dd');
				}
			});

			paper.view.draw();
			
		},

		render: function() {
		    return (
				<canvas id="myCanvas" resize></canvas>
			);
		}
	});