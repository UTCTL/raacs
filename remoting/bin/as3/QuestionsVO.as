package edu.utexas.raacs.model.vo
{
	[Bindable]
	[RemoteClass(alias="QuestionsVO")]
	public class QuestionsVO	
	{
		public var id:int;
		public var creator_id:int;
		public var title:String;
		public var text:String;
		public var picture:String;
		public var answer_type:int;
		public var shared:int;
		public var keywords:String;		
	}
}


