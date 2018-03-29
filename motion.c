#include <stdio.h>
#include <wiringPi.h>
#include <time.h>
#define MOTION 29

int main (void)
{
	time_t timer;
	struct tm *ctm;
	timer = time(NULL);
	time(&timer);
	int i=0, State = 99;


	if(wiringPiSetup() ==-1)
		return 1;

	pinMode(MOTION, INPUT);

	for(;;)
	{
		State=digitalRead(MOTION);
		printf("rpt=%d state = %d ",i,State);
		if(State==0)
			printf("checking = %d normal \n",i);
		else{
			time(&timer);
			ctm=localtime(&timer);
			printf("someone comming 5d:%d:%d \n", ctm->tm_hour, ctm->tm_min, ctm->tm_sec);
		}
		delay(1000);
		i++;
	}
	return 0;
}
