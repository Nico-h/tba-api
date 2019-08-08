# FROM https://github.com/mysql/mysql-docker/blob/mysql-server/5.7

# Copyright (c) 2017, Oracle and/or its affiliates. All rights reserved.
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; version 2 of the License.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301 USA
FROM oraclelinux:7-slim

ARG MYSQL_SERVER_PACKAGE=mysql-community-server-minimal-5.7.27
ARG MYSQL_SHELL_PACKAGE=mysql-shell-8.0.17

# Install server
RUN yum install -y https://repo.mysql.com/mysql-community-minimal-release-el7.rpm \
      https://repo.mysql.com/mysql-community-release-el7.rpm \
  && yum-config-manager --enable mysql57-server-minimal \
  && yum install -y \
      $MYSQL_SERVER_PACKAGE \
      $MYSQL_SHELL_PACKAGE \
      libpwquality \
  && yum clean all \
  && mkdir /docker-entrypoint-initdb.d

VOLUME /var/lib/mysql

# Conf file for mysql to enable outside connexion (bind adress 0.0.0.0)
COPY 50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf

ENV MYSQL_ROOT_PASSWORD=tba
ENV MYSQL_DATABASE=tba
ENV MYSQL_USER=tba
ENV MYSQL_PASSWORD=tba

COPY docker-entrypoint.sh /entrypoint.sh
# Add x right to setup script
RUN chmod +x entrypoint.sh
#COPY healthcheck.sh /healthcheck.sh
ENTRYPOINT ["/entrypoint.sh"]
#HEALTHCHECK CMD /healthcheck.sh
EXPOSE 3306
CMD ["mysqld"]