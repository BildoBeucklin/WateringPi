#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <dirent.h>
#include <string.h>

int main(int argc, char **argv)
{
    DIR *dir;
    struct dirent *ent;
    char dirPath[100];
 	char command[200];
	char fileName[100];

    if (argc < 2) 
    {
        printf("Please specify the directory.\n");
        exit(1);
    }
 
    strcpy(dirPath, argv[1]);

    dir = opendir (dirPath);
 
    // opendir returns NULL if couldn't open directory 
    if (dir == NULL) 
    {
        printf("Error! Could not open directory\n");
        exit(1);
    }
 
    while ((ent = readdir (dir)) != NULL) 
    {
    	if (!strstr(ent->d_name, ".jpg") && !strstr(ent->d_name, ".."))
        { 	
        	sprintf(fileName,"%s/%s", dirPath, ent->d_name);
	        printf("Creating timelapse for %s\n", fileName);
			sprintf(command,"ffmpeg -y -framerate 5 -s 600x400 -pattern_type glob -i '%s/*.jpg' -c:v libx264 -r 30 -pix_fmt yuv420p my_plant_timelapse.mp4", fileName);
			system(command);
        }
    }
    closedir (dir);
    return 0;
}
