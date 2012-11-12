package edu.utexas.raacs.model.vo
{
	[Bindable]
	[RemoteClass(alias="QuestionsQuizzesVO")]
	public class QuestionsQuizzesVO	
	{
		public var id:int;
		public var quiz_id:int;
		public var question_id:int;
		public var think_time:Number;
		public var record_time:Number;
		public var max_takes:int;
		public var total_points:Number;
		public var order:int;		
	}
}


