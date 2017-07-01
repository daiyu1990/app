import Vue from 'vue';
import Router from 'vue-router';
import Main from '../pages/Main';

import AlertPage from '../pages/AlertPage';
import MessPage from '../pages/MessPage';
import DesCrip from "../pages/DesCrip";
import DesModel from "../pages/DesModel";
import MessModel from "../pages/MessModel";
import WorkPage from "../pages/WorkPage";
import Login from "../pages/Login/login";
import Person from "../pages/Login/Person";
import Company from "../pages/Login/Company";
import Register from "../pages/login/Registers";
import AddWork from "../pages/AddWork";
import AddMore from "../pages/AddMore";
import ResWork from "../pages/ResWork";
import Project from "../pages/Project";
import ProjectItem from "../pages/ProjectItem";
import Machine from "../pages/Machine";
import MachineItem from "../pages/MachineItem";
import NewMachine from "../pages/NewMachine";
import MoreUse from "../pages/MoreUse";
import WorkModel from "../pages/WorkModel";
import SubWork from "../pages/SubWork";
import DesProject from "../pages/DesProject";
import NewProject from "../pages/NewProject";
import ProMap from "../pages/ProMap";
import Spread from "../pages/Spread";
import DocMess from "../pages/DocMess";
import CheckMachine from "../pages/CheckMachine";


Vue.use(Router)

var router = new Router({
	routes: [{
			path: '/',
			component: Login
		},
		//登录
		{
			path: '/login',
			component: Login

		},
		//注册
		{
			path: '/register',
			component: Register

		},
		//个人注册
		{
			path: '/person',
			component: Person

		},
		//单位注册
		{
			path: '/company',
			component: Company

		},
		//主页

		{
			path: '/main',
			component: Main

		},
		//报警提醒
		{
			path: "/alertpage",
			component: AlertPage

		},
		
		//报警列表
		{

			path: "/desCrip/:cid/:model",
			component: DesCrip
		},
		//报警详情
		{

			path: "/desmodel/:cid/:tit/:time",
			component: DesModel
		},
		//信息提醒
		{
			path: '/messPage',
			component: MessPage
		},
		
		//信息详情
		{

			path: "/read/:cid/:tit",
			component: MessModel
		},
		//  我的任务
		{

			path: "/WorkPage",
			component: WorkPage
		},
		//任务详情
		{

			path: "/workmodel/:id",
			component: WorkModel
		},
		//任务填报 
		{

			path: "/subwork",
			component: SubWork
		},
		//添加任务
		{

			path: "/addwork",
			component: AddWork
		},
		{

			path: "/addmore",
			component: AddMore
		},
		{

			path: "/reswork",
			component: ResWork
		},
		//工程列表
		{

			path: "/project",
			component: Project
		},
		//工程详情
		{

			path: "/desproject/:order",
			component: DesProject
		},
		//新增工程
		{

			path: "/newproject",
			component: NewProject
		},
		//工程定位
		{

			path: "/promap",
			component: ProMap
		},
		{

			path: "/proitem/:order/:ord_num",
			component: ProjectItem
		},
		//设备信息
		{

			path: "/machine",
			component: Machine
		},
		//设备详情
		{

			path: "/machine/:id",
			component: MachineItem
		},
		//  设备分布
		{

			path: "/spread",
			component: Spread
		},
		//新增设备
		{

			path: "/newmachine",
			component: NewMachine
		},
		//设备报修
		{

			path: "/checkmachine/:id",
			component: CheckMachine
		},
		{

			path: "/moreUse",
			component: MoreUse
		},
		//档案信息
		{

			path: "/docmess",
			component: DocMess
		}

	]
});

export default router;