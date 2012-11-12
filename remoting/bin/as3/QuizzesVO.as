package edu.utexas.raacs.model.vo
{
	[Bindable]
	[RemoteClass(alias="QuizzesVO")]
	public class QuizzesVO	
	{
		public var id:int;
		public var creator_id:int;
		public var title:String;
		public var instructions:String;		
	}
}


