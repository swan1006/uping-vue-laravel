/*

Array of object

Top level object can be:
1. Header
2. Group (Group can have navItems as children)
3. navItem

* Supported Options

/--- Header ---/

header

/--- nav Grp ---/

title
icon (if it's on top level)
tag
tagVariant
children

/--- nav Item ---/

icon (if it's on top level)
title
route: [route_obj/route_name] (I have to resolve name somehow from the route obj)
tag
tagVariant

*/
import dashboard from './dashboard'
import users from './users'
import partners from './partners'
import buyers from './buyers'
import advertisers from './advertisers'
import leads from './leads'
import offers from './offers'
import reports from './reports'
import techarea from './techarea'
import mapping from './mapping'
import invoices from './invoices'


// Array of sections
export default [...dashboard, ...users, ...buyers, ...partners, ...mapping, ...advertisers, ...leads, ...reports, ...offers,...invoices,  ...techarea, ]
