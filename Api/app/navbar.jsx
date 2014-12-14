var Nav = ReactBootstrap.Nav;
var Navbar = ReactBootstrap.Navbar;
var NavItem = ReactBootstrap.NavItem;
var MenuItem = ReactBootstrap.NavItem;
var DropdownButton = ReactBootstrap.DropdownButton;
var navbarNey = (
    <Navbar>
      <Nav>
        <NavItem eventKey={1} href="#">生产管理系统</NavItem>
      </Nav>
      <Nav className="navbar-right">
        <NavItem eventKey={1} href="#">登陆</NavItem>
      </Nav>
    </Navbar>
  );