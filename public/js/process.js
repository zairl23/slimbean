var Process = React.createClass({

		getInitialState: function() {
		    return {data:[]};
		},


		loadCommentsFromServer: function(){
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
		   this.loadCommentsFromServer();
		   setInterval(this.loadCommentsFromServer, this.props.pollInterval);
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

		drawLine:function(fromX, fromY, toX, toY){
			var from = new paper.Point(fromX, fromY);
			var to   = new paper.Point(toX, toY);
			var path = new paper.Path.Line(from, to);
			path.strokeColor = 'black';
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
			this.drawRole(540, 460, '数码部');
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
			this.drawLine(70,360,210,360);//销售到审计
			
			$.each(data, function(index, value){
				if(value.connect_id == 3){
					self.drawLine(240, 330, 240, 290);//审计到仓库id=3
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