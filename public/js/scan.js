var ScanButton = React.createClass({
	render: function(){
		return (
			<div>
				<p>{this.props.data.processName}</p>

				<h1><a className='btn btn-lg btn-success' href={this.props.data.url} role='button'>{this.props.data.words}</a></h1>
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

	handleResize: function(e) {
	  this.setState({windowWidth: window.innerWidth});
	},

	componentDidMount: function() {
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
