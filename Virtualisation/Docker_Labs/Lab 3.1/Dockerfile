#Version: 0.0.1
#Container for Apache, OpenSSHServer and Supervisor
#Operating System
FROM ubuntu:14.04
MAINTAINER Glenn Richards "richgl@student.op.ac.nz"
#Commands
RUN apt-get update && apt-get -y upgrade
RUN apt-get install -y apache2
RUN apt-get install -y openssh-server
RUN apt-get install -y supervisor
#Custom Files
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
#Ports
EXPOSE 22
EXPOSE 80
#Commands
CMD ["/usr/bin/supervisord"]
#End of File
