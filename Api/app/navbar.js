/** @jsx React.DOM */
var Nav = ReactBootstrap.Nav;
var Navbar = ReactBootstrap.Navbar;
var NavItem = ReactBootstrap.NavItem;
var MenuItem = ReactBootstrap.NavItem;
var DropdownButton = ReactBootstrap.DropdownButton;
var NavbarNey = (
    <Navbar>
      <Nav>
        <NavItem eventKey={1} href="#">生产管理系统</NavItem>
      </Nav>
      <Nav className="navbar-right">
        <NavItem eventKey={1} href="#">登陆</NavItem>
      </Nav>
    </Navbar>
);

var NavbarNeyChang = React.createClass({

	welcomeName: function(){
		// document.cookie = 'username=neychang';
		if(this.isLogined()){
			return '您好！ ' + this.getCookie('username');
		}else{
			return '登陆';
		}
	},

	isLogined: function(){
		if(this.getCookie('username') == ''){
			return false;
		}else{
			return true;
		}
	},

	getCookie: function(cname){
		var name = cname + "=";
		    var ca = document.cookie.split(';');
		    for(var i=0; i<ca.length; i++) {
		        var c = ca[i];
		        while (c.charAt(0)==' ') c = c.substring(1);
		        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
		    }
		    return "";
	},

	render: function(){
		return (
			<Navbar>
			  <Nav>
			    <NavItem eventKey={1} href="#">生产管理系统</NavItem>
			  </Nav>
			  <Nav className="navbar-right">
			    <NavItem eventKey={1} href="#">{this.welcomeName()}</NavItem>
			  </Nav>
			</Navbar>
		);
	}
});