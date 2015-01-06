var ScanButton = React.createClass({
	// mixins: [Scan],

	handleClick: function(){
		console.log('hehhe');

		if(this.props.data.url == '#1'){
			return false;
		}else{
			$.ajax({
				url: '/order/operate',
				dataType: 'json',
				type: 'POST',
				data: {connect_id: this.props.data.connect_id, order_id: this.props.data.order_id, to_id: this.props.data.to_id},
				success: function(data) {
					// this.setState({data: data});
					window.location = '/special/showOrder/' + this.props.data.order_id;
				}.bind(this),
				error: function(xhr, status, err) {
					console.error('/order/operate', status, err.toString());
				}.bind(this)
			});
		}
	},

	render: function(){
		if(this.props.data.url == '#1'){
			var styleName = 'btn btn-lg btn-danger';
		}else{
			var styleName = 'btn btn-lg btn-success';
		}
		
		return (
			<div>
				<p>{this.props.data.processName}</p>

				<h1><a className={styleName} onClick={this.handleClick} href={this.props.data.url} role='button'>{this.props.data.words}</a></h1>
			</div>
		);
	}
});

var ScanButtonList = React.createClass({
	render: function() {
		var ScanButtonList = this.props.data.map(function(value){
			return <ScanButton data={value} />;
		});	

		return (
			<div>
				{ScanButtonList}
			</div>
		);
	}
});

var Scan = React.createClass({

	getInitialState: function() {
	    return {data:[]};
	},

	loadOperationsFromServer: function(){
		$.ajax({
		     url: this.props.url,
		     dataType: 'json',
		     success: function(data) {
		       this.setState({data: data});
		     }.bind(this),
		     error: function(xhr, status, err) {
		       console.error(this.props.url, status, err.toString());
		     }.bind(this)
		});
	},

	componentDidMount: function() {
		this.loadOperationsFromServer();

		setInterval(this.loadStatusFromServer, 2000);
		
	 	// window.addEventListener('resize', this.handleResize);
	},

	render: function() {
		return (
		    <div>
		    	<ScanButtonList data={this.state.data} />
		    </div>
		);
	}

});
